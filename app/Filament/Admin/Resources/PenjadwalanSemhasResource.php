<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PenjadwalanSemhasResource\Pages;
use App\Filament\Admin\Resources\PenjadwalanSemhasResource\RelationManagers;
use App\Models\PenjadwalanSemhas;
use App\Models\UjianSkripsi;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenjadwalanSemhasResource extends Resource
{
    protected static ?string $model = UjianSkripsi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Seminar Hasil';
    protected static ?string $pluralLabel = 'Seminar Hasil';
    protected static ?string $slug = 'seminar-hasil';
    protected static ?string $navigationGroup = 'Penjadwalan Ujian';
    protected static ?int $navigationSort = 3;

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
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(UjianSkripsi::query()->seminarHasilTerverifikasi())
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
                TextColumn::make('skripsi.judul')
                    ->label('Judul')
                    ->wrap(),
                TextColumn::make('skripsi.dosen.name')
                    ->label('Dosen Pembimbing'),
            ])
            ->filters([
                Tables\Filters\Filter::make('Belum Dijadwalkan')
                  ->query(fn (Builder $query) => $query->whereNull('tanggal_seminar')),

                Tables\Filters\Filter::make('Sudah Dijadwalkan')
                    ->query(fn (Builder $query) => $query->whereNotNull('tanggal_seminar')),
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
            'index' => Pages\ManagePenjadwalanSemhas::route('/'),
        ];
    }
}
