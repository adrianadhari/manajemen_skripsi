<?php

namespace App\Filament\Dosen\Resources;

use App\Filament\Dosen\Resources\LogBimbinganResource\Pages;
use App\Filament\Dosen\Resources\LogBimbinganResource\RelationManagers;
use App\Filament\Dosen\Resources\LogBimbinganResource\RelationManagers\BimbingansRelationManager;
use App\Models\LogBimbingan;
use App\Models\Skripsi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;


class LogBimbinganResource extends Resource
{
    protected static ?string $model = Skripsi::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Log Bimbingan';
    protected static ?string $pluralLabel = 'Log Bimbingan';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function ($query) {
                $query->where('dosen_id', auth()->id())
                    ->orWhere('co_dosen_id', auth()->id());
            });
    }

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
                TextColumn::make('mahasiswa.name')->label('Nama Mahasiswa'),
                TextColumn::make('mahasiswa.no_induk')->label('NPM'),
                TextColumn::make('judul')->label('Judul Skripsi'),
                TextColumn::make('jumlah_log')
                    ->label('Jumlah Log Bimbingan')
                    ->state(fn(Skripsi $record) => $record->bimbingans()->count()),
            ])
            ->actions([
                Action::make('lihat_log')
                    ->label('Lihat Log')
                    ->url(fn(Skripsi $record) => LogBimbinganResource::getUrl(name: 'edit', parameters: ['record' => $record]))
                    ->icon('heroicon-o-eye'),
                Action::make('approve_seminar_proposal')
                    ->label('Approve Seminar Proposal')
                    ->color('success')
                    ->requiresConfirmation() // << INI tambahan penting
                    ->modalHeading('Konfirmasi Persetujuan')
                    ->modalSubheading('Apakah Anda yakin ingin menyetujui seminar proposal ini?')
                    ->modalButton('Ya, Setujui')
                    ->visible(fn (Skripsi $record) => $record->bimbingans()->count() >= 6 && $record->seminar_proposal_approved_at == null)
                    ->action(function (Skripsi $record) {
                        $record->update(['seminar_proposal_approved_at' => now()]);
                        Notification::make()
                            ->title('Seminar Proposal Disetujui')
                            ->success()
                            ->send();
                    }),
                    // ->color('success')
                    // ->icon('heroicon-o-check-circle'),
                Action::make('approve_seminar_hasil')
                    ->label('Approve Seminar Hasil')
                    ->color('success')
                    ->requiresConfirmation() // << INI tambahan penting
                    ->modalHeading('Konfirmasi Persetujuan')
                    ->modalSubheading('Apakah Anda yakin ingin menyetujui seminar hasil ini?')
                    ->modalButton('Ya, Setujui')
                    ->visible(fn (Skripsi $record) => $record->bimbingans()->count() >= 6 && $record->seminar_hasil_approved_at == null)
                    ->action(function (Skripsi $record) { 
                        $record->update(['seminar_hasil_approved_at' => now()]);
                        Notification::make()
                            ->title('Seminar Hasil Disetujui')
                            ->success()
                            ->send();
                    }),
                    // ->color('success')
                    // ->icon('heroicon-o-check-circle'),
                Action::make('approve_sidang')
                    ->label('Approve Sidang Skripsi')
                    ->color('success')
                    ->requiresConfirmation() // << INI tambahan penting
                    ->modalHeading('Konfirmasi Persetujuan')
                    ->modalSubheading('Apakah Anda yakin ingin menyetujui seminar hasil ini?')
                    ->modalButton('Ya, Setujui')
                    ->visible(fn (Skripsi $record) => $record->bimbingans()->count() >= 4 && $record->sidang_skripsi_approved_at == null)
                    ->action(function (Skripsi $record) {
                        $record->update(['sidang_skripsi_approved_at' => now()]);
                        Notification::make()
                            ->title('Sidang Skripsi Disetujui')
                            ->success()
                            ->send();
                    }),
                    // ->color('success')
                    // ->icon('heroicon-o-check-circle'),
            
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            BimbingansRelationManager::class
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLogBimbingans::route('/'),
            'edit' => Pages\EditLogBimbingan::route('/{record}/edit'),
        ];
    }
}
