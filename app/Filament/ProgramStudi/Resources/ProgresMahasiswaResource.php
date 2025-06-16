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
            ->actions([
                Tables\Actions\Action::make('lihat_log')
                    ->label('Lihat Log Bimbingan')
                    ->icon('heroicon-o-clipboard-document')
                    ->modalHeading(fn($record) => 'Log Bimbingan - ' . $record->name)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(function (User $record) {
                        $bimbingans = $record->skripsiDisetujui?->bimbingans;

                        if ($bimbingans->isEmpty()) {
                            return 'Belum ada log bimbingan.';
                        }

                        $html = '<div class="space-y-4">';

                        foreach ($bimbingans as $bimbingan) {
                            $html .= '<div class="border p-4 rounded-md bg-gray-50">
                    <p><strong>Tanggal:</strong> ' . $bimbingan->created_at->format('d-m-Y H:i') . '</p>
                    <p><strong>Catatan Mahasiswa:</strong><br>' . nl2br(e($bimbingan->catatan_kegiatan)) . '</p>
                    <p><strong>Evaluasi Dosen:</strong><br>' . nl2br(e($bimbingan->catatan_evaluasi)) . '</p>
                </div>';
                        }

                        $html .= '</div>';

                        return new \Illuminate\Support\HtmlString($html);
                    })
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProgresMahasiswas::route('/'),
        ];
    }
}
