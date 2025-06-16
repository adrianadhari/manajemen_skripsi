<?php

namespace App\Filament\ProgramStudi\Resources;

use App\Filament\ProgramStudi\Resources\ApprovePenjadwalanUjianResource\Pages;
use App\Filament\ProgramStudi\Resources\ApprovePenjadwalanUjianResource\RelationManagers;
use App\Models\ApprovePenjadwalanUjian;
use App\Models\UjianSkripsi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApprovePenjadwalanUjianResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
        protected static ?string $navigationLabel = 'Approve Jadwal Ujian';
    protected static ?string $pluralLabel = 'Approve Jadwal Ujian';
    protected static ?string $slug = 'approve-jadwal-ujian';


    public static function table(Table $table): Table
    {
        return $table
            ->query(
                UjianSkripsi::query()
                    ->with(['skripsi.mahasiswa', 'penguji1', 'penguji2'])
                    ->whereNotNull('tanggal_seminar')
                    ->where(function ($query) {
                        $query->where('is_schedule_approved_by_prodi', false)
                            ->orWhereNull('is_schedule_approved_by_prodi');
                    })
            )
            ->columns([
                TextColumn::make('skripsi.mahasiswa.name')->label('Nama Mahasiswa'),
                TextColumn::make('jenis_ujian')->label('Jenis Ujian'),

                TextColumn::make('tanggal_seminar')->label('Tanggal')->date(),
                TextColumn::make('waktu_seminar')->label('Waktu')->time(),
                TextColumn::make('ruangan')->label('Ruangan'),

                TextColumn::make('penguji1.name')->label('Dosen Penguji 1'),
                TextColumn::make('penguji2.name')->label('Dosen Penguji 2'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('approve_jadwal')
                    ->label('Setujui Jadwal')
                    ->visible(fn($record) => !$record->is_schedule_approved_by_prodi && $record->tanggal_seminar)
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'is_schedule_approved_by_prodi' => true,
                            'schedule_approved_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Jadwal disetujui oleh Program Studi')
                            ->success()
                            ->send();
                    })
                    ->icon('heroicon-o-check-circle')
                    ->color('success'),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageApprovePenjadwalanUjians::route('/'),
        ];
    }
}
