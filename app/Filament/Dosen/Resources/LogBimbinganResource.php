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
use Filament\Tables\Actions\ViewAction;

class LogBimbinganResource extends Resource
{
    protected static ?string $model = Skripsi::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Log Bimbingan';
    protected static ?string $pluralLabel = 'Log Bimbingan';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('bimbingans')
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
                TextColumn::make('judul')->label('Judul Skripsi')
                    ->wrap(),
                TextColumn::make('jumlah_log')
                    ->label('Jumlah Log Bimbingan')
                    ->state(fn(Skripsi $record) => $record->bimbingans()->count()),
            ])
            ->actions([
                Action::make('approveSempro')
                    ->label('Approve untuk Seminar Proposal')
                    ->visible(
                        fn($record) =>
                        !$record->is_approved_for_sempro &&
                            $record->bimbingans->count() >= 4 &&
                            $record->bimbingans->every(fn($b) => filled($b->catatan_evaluasi))
                    )
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'is_approved_for_sempro' => true,
                            'approved_for_sempro_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Disetujui untuk Seminar Proposal')
                            ->success()
                            ->send();
                    }),

                Action::make('approveSemhas')
                    ->label('Approve untuk Seminar Hasil')
                    ->visible(
                        fn($record) =>
                        $record->is_approved_for_sempro &&
                            !$record->is_approved_for_semhas &&
                            $record->bimbingans->count() >= 8 &&
                            $record->bimbingans->every(fn($b) => filled($b->catatan_evaluasi))
                    )
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'is_approved_for_semhas' => true,
                            'approved_for_semhas_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Disetujui untuk Seminar Hasil')
                            ->success()
                            ->send();
                    }),

                Action::make('approveSidang')
                    ->label('Approve untuk Sidang Skripsi')
                    ->visible(
                        fn($record) =>
                        $record->is_approved_for_sempro &&
                            $record->is_approved_for_semhas &&
                            !$record->is_approved_for_sidang &&
                            $record->bimbingans->count() >= 10 &&
                            $record->bimbingans->every(fn($b) => filled($b->catatan_evaluasi))
                    )
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'is_approved_for_sidang' => true,
                            'approved_for_sidang_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Disetujui untuk Sidang Skripsi')
                            ->success()
                            ->send();
                    }),
                Action::make('lihat_log')
                    ->label('Lihat Log')
                    ->url(fn(Skripsi $record) => LogBimbinganResource::getUrl(name: 'edit', parameters: ['record' => $record]))
                    ->icon('heroicon-o-eye'),
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
