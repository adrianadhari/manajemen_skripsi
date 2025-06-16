<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\PengajuanJudulResource\Pages;
use App\Filament\Mahasiswa\Resources\PengajuanJudulResource\RelationManagers;
use App\Models\PengajuanJudul;
use App\Models\Skripsi; //model utama
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengajuanJudulResource extends Resource
{
    protected static ?string $model = Skripsi::class; //resource ini mengelola data dari tabel skripsis.

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?string $navigationLabel = 'Pengajuan Judul'; //nama menu sidebar
    protected static ?string $pluralLabel = 'Daftar Judul'; //judul halaman
    protected static ?string $title = 'Daftar Judul';
    protected static ?string $slug = 'pengajuan-judul';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Tambahan field: hanya muncul saat view
                Textarea::make('judul')
                    ->required()
                    ->autosize()
                    ->label('Judul Penelitian')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Radio::make('bidang')
                    ->label('Topik Penelitian')
                    ->options([
                        'Data Analyst' => 'Data Analyst',
                        'Rancang Bangun' => 'Rancang Bangun',
                        'SPK' => 'SPK',
                        'Cyber System' => 'Cyber System'
                    ])
                    ->inline()
                    ->required()
                    ->inlineLabel(false)
                    ->columnSpanFull(),
                FileUpload::make('attachment')
                    ->label('Upload Draft Outline Pengajuan Judul Penelitian')
                    ->directory('draft_outline')
                    ->acceptedFileTypes(['application/pdf'])
                    ->placeholder('PDF maksimal 5MB')
                    ->maxSize(5120)
                    ->columnSpanFull()
                    ->visible(fn(string $operation): bool => $operation !== 'view'),
                FileUpload::make('attachment')
                    ->label('Upload Transkrip Nilai')
                    ->directory('transkrip_nilai')
                    ->acceptedFileTypes(['application/pdf'])
                    ->placeholder('PDF maksimal 5MB')
                    ->maxSize(5120)
                    ->columnSpanFull()
                    ->visible(fn(string $operation): bool => $operation !== 'view'),
                FileUpload::make('attachment')
                    ->label('Upload KRS')
                    ->directory('draft_outline')
                    ->acceptedFileTypes(['application/pdf'])
                    ->placeholder('PDF maksimal 5MB')
                    ->maxSize(5120)
                    ->columnSpanFull()
                    ->visible(fn(string $operation): bool => $operation !== 'view'),
                Placeholder::make('dosen.name')
                    ->label('Dosen Pembimbing 1')
                    ->disabled()
                    ->content(fn($record) => $record->dosen?->name ?? '-')
                    ->visible(fn(string $operation): bool => $operation === 'view'),
                Placeholder::make('coDosen.name')
                    ->label('Dosen Pembimbing 2')
                    ->disabled()
                    ->content(fn($record) => $record->coDosen?->name ?? '-')
                    ->visible(fn(string $operation): bool => $operation === 'view'),
                Hidden::make('mahasiswa_id')
                    ->default(fn() => Filament::auth()->user()->id)
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['dosen']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Skripsi::query()->where('mahasiswa_id', auth()->user()->id)) //hanya menampilkan data milik mahasiswa yang sedang login.
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->date(),
                TextColumn::make('bidang')
                    ->label('Topik Penelitian'),
                TextColumn::make('judul')
                    ->label('Judul Penelitian')
                    ->wrap(),
                TextColumn::make('status')
                    ->label('Status Judul')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Diajukan' => 'gray',
                        'Disetujui' => 'success',
                        'Ditolak' => 'danger',
                    })

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->modalHeading('Detail Pengajuan Judul')
                ->modalCancelAction(false),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePengajuanJuduls::route('/'), //menunjuk ke page utama resource
        ];
    }
}
