<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KelolaMahasiswaResource\Pages;
use App\Filament\Admin\Resources\KelolaMahasiswaResource\RelationManagers;
use App\Models\KelolaMahasiswa;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelolaMahasiswaResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Kelola User';
    protected static ?string $navigationLabel = 'Mahasiswa';
    protected static ?string $pluralLabel = 'Mahasiswa';
    protected static ?string $slug = 'mahasiswa';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Mahasiswa')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('no_induk')
                    ->required()
                    ->label('NPM')
                    ->unique(ignoreRecord: true),
                Select::make('kelas')
                    ->options([
                        'Pagi-A' => 'Pagi-A',
                        'Pagi-B' => 'Pagi-B',
                        'Pagi-C' => 'Pagi-C',
                        'Karyawan-A' => 'Karyawan-A',
                        'Karyawan-B' => 'Karyawan-B',
                    ]),
                TextInput::make('no_hp')
                    ->numeric()
                    ->label('No. HP')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(User::query()->where('role', 'Mahasiswa'))
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Mahasiswa')
                    ->wrap(),
                TextColumn::make('email'),
                TextColumn::make('no_induk')
                    ->label('NPM'),
                TextColumn::make('kelas')
                    ->placeholder('-'),
                TextColumn::make('no_hp')
                    ->label('No. HP')
                    ->placeholder('-'),
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
            'index' => Pages\ManageKelolaMahasiswas::route('/'),
        ];
    }
}
