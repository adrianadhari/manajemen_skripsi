<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\VerifikasiMahasiswaResource\Pages;
use App\Filament\Admin\Resources\VerifikasiMahasiswaResource\RelationManagers;
use App\Models\UjianSkripsi;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VerifikasiMahasiswaResource extends Resource
{
    protected static ?string $model = UjianSkripsi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Verifikasi Mahasiswa';
    protected static ?string $pluralLabel = 'Verifikasi Mahasiswa';
    protected static ?string $title = 'Verifikasi Mahasiswa';
    protected static ?string $slug = 'verifikasi-mahasiswa';
    protected static ?int $navigationSort = 1;

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
            ->columns([
                TextColumn::make('jenis_ujian')
                    ->label('Jenis Ujian'),
                TextColumn::make('skripsi.mahasiswa.name')
                    ->label('Mahasiswa'),
                TextColumn::make('skripsi.mahasiswa.no_induk')
                    ->label('NPM'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Menunggu Verifikasi' => 'gray',
                        'Terverifikasi' => 'success',
                        'Ditolak' => 'danger',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('verifikasi')
                    ->label('Ubah Status')
                    ->form([
                        Select::make('status')
                            ->label('Status Verifikasi')
                            ->options([
                                'Terverifikasi' => 'Terverifikasi',
                                'Ditolak' => 'Ditolak',
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data, UjianSkripsi $record) {
                        $record->update([
                            'status' => $data['status'],
                        ]);
                    })
                    ->modalHeading('Ubah Status Pendaftaran')
                    ->modalSubmitActionLabel('Simpan')
                    ->color('primary')
                    ->icon('heroicon-o-pencil-square')
            ])

            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageVerifikasiMahasiswas::route('/'),
        ];
    }
}
