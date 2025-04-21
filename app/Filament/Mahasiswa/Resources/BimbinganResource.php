<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\BimbinganResource\Pages;
use App\Filament\Mahasiswa\Resources\BimbinganResource\RelationManagers;
use App\Models\Bimbingan;
use App\Models\Skripsi;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BimbinganResource extends Resource
{
    protected static ?string $model = Bimbingan::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Log Bimbingan';
    protected static ?string $pluralLabel = 'Log Bimbingan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $userId = Filament::auth()->user()->id;

        // Cari skripsi yang statusnya 'Disetujui' dan milik user
        $skripsiDisetujui = Skripsi::where('mahasiswa_id', $userId)
            ->where('status', 'Disetujui')
            ->first();

        return $form
            ->schema([
                DatePicker::make('tanggal_bimbingan')
                    ->required()
                    ->label('Tanggal Bimbingan')
                    ->columnSpanFull(),
                Textarea::make('catatan_kegiatan')
                    ->label('Catatan Kegiatan')
                    ->required()
                    ->autosize()
                    ->columnSpanFull(),
                Hidden::make('skripsi_id')
                    ->default($skripsiDisetujui?->id)
            ]);
    }

    public static function table(Table $table): Table
    {
        $skripsiMilik = Skripsi::where('mahasiswa_id', auth()->user()->id)->where('status', 'Disetujui')->first();
        return $table
            ->query(Bimbingan::query()->where('skripsi_id', $skripsiMilik?->id))
            ->columns([
                TextColumn::make('index')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('tanggal_bimbingan')
                    ->label('Tanggal Bimbingan')
                    ->date(),
                TextColumn::make('catatan_kegiatan')
                    ->label('Kegiatan Mahasiswa')
                    ->wrap(),
                TextColumn::make('catatan_evaluasi')
                    ->label('Evaluasi Bimbingan')
                    ->wrap()
                    ->placeholder('Belum di isi')
            ])
            ->defaultSort('tanggal_bimbingan', 'asc')
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
            'index' => Pages\ManageBimbingans::route('/'),
        ];
    }
}
