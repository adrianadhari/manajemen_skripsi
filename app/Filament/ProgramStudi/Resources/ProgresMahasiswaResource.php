<?php

namespace App\Filament\ProgramStudi\Resources;

use App\Filament\ProgramStudi\Resources\ProgresMahasiswaResource\Pages;
use App\Filament\ProgramStudi\Resources\ProgresMahasiswaResource\RelationManagers;
use App\Models\ProgresMahasiswa;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgresMahasiswaResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?string $navigationLabel = 'Progres Mahasiswa';
    protected static ?string $pluralLabel = 'Progres Mahasiswa';

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
                    ->whereHas('skripsiDisetujui')
                    ->with(['skripsiDisetujui.dosen', 'skripsiDisetujui.coDosen', 'skripsiDisetujui.bimbingans'])
            )
            ->columns([
                TextColumn::make('name')->label('Nama Mahasiswa'),
                TextColumn::make('no_induk')->label('NPM'),

                TextColumn::make('skripsiDisetujui.dosen.name')
                    ->label('Pembimbing 1'),
                TextColumn::make('skripsiDisetujui.coDosen.name')
                    ->label('Pembimbing 2'),

                TextColumn::make('skripsi.judul')
                    ->label('Judul Skripsi')
                    ->wrap(),

                TextColumn::make('Jumlah Bimbingan')
                    ->label('Jumlah Bimbingan')
                    ->getStateUsing(fn($record) => $record->skripsiDisetujui?->bimbingans->count() ?? 0)

            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProgresMahasiswas::route('/'),
        ];
    }
}
