<?php

namespace App\Filament\Dosen\Resources;

use App\Filament\Dosen\Resources\MahasiswaBimbinganResource\Pages;
use App\Filament\Dosen\Resources\MahasiswaBimbinganResource\RelationManagers;
use App\Models\MahasiswaBimbingan;
use App\Models\Skripsi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MahasiswaBimbinganResource extends Resource
{
    protected static ?string $model = Skripsi::class;
    protected static ?string $navigationLabel = 'Mahasiswa Bimbingan';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $pluralLabel = 'Mahasiswa Bimbingan';
    protected static ?string $slug = 'mahasiswa-bimbingan';

    public static function table(Table $table): Table
    {
        return $table
            ->query(Skripsi::query()
                ->with('mahasiswa')
                ->where('dosen_id', auth()->id())
                ->where('status', 'Disetujui')
            )
            ->columns([
                TextColumn::make('mahasiswa.name')->label('Nama Mahasiswa'),
                TextColumn::make('mahasiswa.no_induk')->label('NPM'),
                TextColumn::make('judul')->label('Judul Skripsi')->wrap(),
                TextColumn::make('created_at')->label('Tanggal Disetujui')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMahasiswaBimbingans::route('/'),
        ];
    }
}
