<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PenjadwalanSemproResource\Pages;
use App\Filament\Admin\Resources\PenjadwalanSemproResource\RelationManagers;
use App\Models\PenjadwalanSempro;
use App\Models\UjianSkripsi;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Components\Tab;
use Filament\Forms\Components\Tabs;




class PenjadwalanSemproResource extends Resource
{
    protected static ?string $model = UjianSkripsi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Seminar Proposal';
    protected static ?string $pluralLabel = 'Seminar Proposal';
    protected static ?string $slug = 'seminar-proposal';
    protected static ?string $navigationGroup = 'Penjadwalan Ujian';
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('tanggal_seminar')
                    ->label('Tanggal Seminar')
                    ->columnSpanFull(),
                TimePicker::make('waktu_seminar')
                    ->label('Waktu Seminar')
                    ->columnSpanFull(),
                TextInput::make('ruangan')
                    ->columnSpanFull(),
                Select::make('penguji_1_id')
                    ->label('Dosen Penguji')
                    ->options(function ($get, $record) {
                        $skripsi = $record->skripsi;
                        return User::query()
                            ->where('role', 'Dosen')
                            ->where('id', '!=', $skripsi->dosen_id)
                            ->when($skripsi->co_dosen_id, fn($q) => $q->where('id', '!=', $skripsi->co_dosen_id))
                            ->pluck('name', 'id');
                    })
                    ->required()
                    ->columnSpanFull()
                    ->searchable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(UjianSkripsi::query()->seminarProposalTerverifikasi())
            ->columns([
                TextColumn::make('index')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('created_at')
                    ->label('Tanggal Pendaftaran')
                    ->dateTime(),
                TextColumn::make('skripsi.mahasiswa.name')
                    ->label('Mahasiswa'),
                TextColumn::make('skripsi.mahasiswa.no_induk')
                    ->label('NPM'),
                TextColumn::make('skripsi.kelas')
                    ->label('Kelas'),
                TextColumn::make('skripsi.judul')
                    ->label('Judul')
                    ->wrap(),
                TextColumn::make('skripsi.dosen.name')
                    ->label('Dosen Pembimbing'),
            ])
            ->filters([
                Tables\Filters\Filter::make('Belum Dijadwalkan')
                    ->query(fn(Builder $query) => $query->whereNull('tanggal_seminar')),

                Tables\Filters\Filter::make('Sudah Dijadwalkan')
                    ->query(fn(Builder $query) => $query->whereNotNull('tanggal_seminar')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Buat Jadwal'),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePenjadwalanSempros::route('/'),
        ];
    }
}
