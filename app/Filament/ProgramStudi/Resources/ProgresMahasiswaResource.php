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
                    ->whereHas('skripsi')
                    ->with(['skripsi.dosen', 'skripsi.coDosen', 'skripsi.bimbingans'])
            )
            ->columns([
                TextColumn::make('name')->label('Nama Mahasiswa'),
                TextColumn::make('no_induk')->label('NPM'),

                TextColumn::make('nama_pembimbing')
                    ->label('Nama Pembimbing')
                    ->formatStateUsing(function ($state, $record) {
                        $pembimbing1 = $record->skripsi?->dosen?->name;
                        $pembimbing2 = $record->skripsi?->coDosen?->name;
                        return collect([$pembimbing1, $pembimbing2])
                            ->filter()
                            ->implode(', ');
                    }),

                TextColumn::make('skripsi.judul')
                    ->label('Judul Skripsi'),

                TextColumn::make('jumlah_bimbingan')
                    ->label('Jumlah Log Bimbingan')
                    ->formatStateUsing(fn($state, $record) => $record->skripsi?->bimbingans?->count() ?? 0)

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
