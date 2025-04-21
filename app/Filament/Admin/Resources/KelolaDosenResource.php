<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KelolaDosenResource\Pages;
use App\Filament\Admin\Resources\KelolaDosenResource\RelationManagers;
use App\Models\KelolaDosen;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelolaDosenResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Kelola User';
    protected static ?string $navigationLabel = 'Dosen';
    protected static ?string $pluralLabel = 'Dosen';
    protected static ?string $slug = 'dosen';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Dosen')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('no_induk')
                    ->required()
                    ->label('NIP')
                    ->unique(ignoreRecord: true),
                TextInput::make('no_hp')
                    ->numeric()
                    ->label('No. HP')
                    ->maxLength(255),
                Hidden::make('role')
                    ->default('Dosen')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(User::query()->where('role', 'Dosen'))
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Dosen')
                    ->wrap(),
                TextColumn::make('email'),
                TextColumn::make('no_induk')
                    ->label('NIP')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageKelolaDosens::route('/'),
        ];
    }
}
