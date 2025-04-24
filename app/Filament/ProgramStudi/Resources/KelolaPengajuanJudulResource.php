<?php

namespace App\Filament\ProgramStudi\Resources;

use App\Filament\ProgramStudi\Resources\KelolaPengajuanJudulResource\Pages;
use App\Filament\ProgramStudi\Resources\KelolaPengajuanJudulResource\RelationManagers;
use App\Models\Skripsi;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class KelolaPengajuanJudulResource extends Resource
{
    protected static ?string $model = Skripsi::class;

    protected static ?string $navigationLabel = 'Kelola Pengajuan Judul';
    protected static ?string $pluralLabel = 'Kelola Pengajuan Judul';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'kelola-pengajuan-judul';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->where('role', 'Mahasiswa')
                    ->whereHas('semuaSkripsi')
            )
            ->columns([
                TextColumn::make('name')->label('Nama Mahasiswa'),
                TextColumn::make('no_induk')->label('NPM'),
                TextColumn::make('kelas'),
            ])
            ->actions([
                Action::make('tinjau_pengajuan')
                    ->label(fn($record) => $record->sudahPunyaSkripsiDisetujui() ? 'Telah Dipilih' : 'Tinjau Pengajuan Judul')
                    ->disabled(fn($record) => $record->sudahPunyaSkripsiDisetujui())
                    ->form(function (User $record) {
                        $judulCollection = $record->skripsi()
                            ->where('status', 'Diajukan')
                            ->get();

                        return [
                            Repeater::make('judul_list')
                                ->label('Daftar Judul yang Diajukan')
                                ->schema([
                                    Placeholder::make('judul')->label('Judul')
                                        ->content(fn($get) => $get('judul')),
                                    Placeholder::make('bidang')->label('Bidang')
                                        ->content(fn($get) => $get('bidang')),
                                    Placeholder::make('attachment')->label('File Draft Outline')
                                        ->content(fn($get) => new HtmlString('<a href="' . asset('storage/' . $get('attachment')) . '" target="_blank" class="text-primary underline">Lihat File</a>'))
                                        ->columnSpanFull()
                                        ->extraAttributes(['class' => 'filament-tables-text-column'])
                                ])
                                ->columns(2)
                                ->default(
                                    $judulCollection->map(fn($item) => [
                                        'judul' => $item->judul,
                                        'bidang' => $item->bidang,
                                        'attachment' => $item->attachment,
                                    ])->toArray()
                                )
                                ->disabled()
                                ->deletable(false)
                                ->reorderable(false)
                                ->cloneable(false),

                            Select::make('judul_id')
                                ->label('Pilih Judul yang Disetujui')
                                ->options(
                                    $judulCollection->pluck('judul', 'id')->toArray()
                                )
                                ->required(),

                            Select::make('dosen_id')
                                ->label('Dosen Pembimbing 1')
                                ->options(User::where('role', 'Dosen')->pluck('name', 'id'))
                                ->required(),

                            Select::make('co_dosen_id')
                                ->label('Dosen Pembimbing 2 (Opsional)')
                                ->options(User::where('role', 'Dosen')->pluck('name', 'id'))
                                ->searchable()
                                ->nullable(),
                        ];
                    })
                    ->action(function (array $data, User $record) {
                        Skripsi::where('id', $data['judul_id'])->update([
                            'status' => 'Disetujui',
                            'dosen_id' => $data['dosen_id'],
                            'co_dosen_id' => $data['co_dosen_id'],
                        ]);

                        Skripsi::where('mahasiswa_id', $record->id)
                            ->where('id', '!=', $data['judul_id'])
                            ->where('status', 'Diajukan')
                            ->update(['status' => 'Ditolak']);
                    })
                    ->icon('heroicon-o-clipboard-document-check')
                    ->modalHeading('Verifikasi Judul Skripsi')
                    ->modalSubmitActionLabel('Simpan')
                    ->color('primary')
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageKelolaPengajuanJuduls::route('/'),
        ];
    }
}
