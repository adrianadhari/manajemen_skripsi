<?php

namespace App\Filament\Dosen\Resources\LogBimbinganResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BimbingansRelationManager extends RelationManager
{
    protected static string $relationship = 'bimbingans';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('tanggal_bimbingan')->required(),
                Textarea::make('catatan_kegiatan')->required(),
                Textarea::make('catatan_evaluasi'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tanggal_bimbingan')
            ->columns([
                TextColumn::make('tanggal_bimbingan')->label('Tanggal'),
                TextColumn::make('catatan_kegiatan')->label('Catatan Kegiatan'),
                TextColumn::make('catatan_evaluasi')->label('Catatan Evaluasi'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
            ]);
    }
}
