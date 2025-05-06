<?php

namespace App\Filament\ProgramStudi\Pages;

use App\Models\User;
use App\Models\Skripsi;
use App\Models\UjianSkripsi;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class KuotaDosen extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationLabel = 'Kuota Dosen';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = null;

    protected static string $view = 'filament.program-studi.pages.kuota-dosen';

    protected function getTableQuery()
    {
        return User::query()
            ->where('role', 'dosen');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Dosen Pembimbing'),

            TextColumn::make('bimbingan_aktif')
                ->label('Jml Bimbingan Aktif')
                ->getStateUsing(function (User $record) {
                    return Skripsi::where('dosen_id', $record->id)
                        ->orWhere('co_dosen_id', $record->id)
                        ->where('status', 'Sedang Dibimbing')
                        ->count();
                })
                ->alignEnd(),

            TextColumn::make('mahasiswa_lulus')
                ->label('Jml Mhs Lulus')
                ->getStateUsing(function (User $record) {
                    return UjianSkripsi::whereHas('skripsi', function ($query) use ($record) {
                        $query->where('dosen_id', $record->id)
                              ->orWhere('co_dosen_id', $record->id);
                    })->where('status', 'Terverifikasi')
                      ->count();
                })
                ->alignEnd(),

                TextColumn::make('presentase_lulus')
                ->label('Presentase Mhs Lulus')
                ->getStateUsing(function (User $record) {
                    $bimbinganAktif = Skripsi::where('dosen_id', $record->id)
                        ->orWhere('co_dosen_id', $record->id)
                        ->where('status', 'Sedang Dibimbing')
                        ->count();
            
                    $mahasiswaLulus = UjianSkripsi::whereHas('skripsi', function ($query) use ($record) {
                        $query->where('dosen_id', $record->id)
                              ->orWhere('co_dosen_id', $record->id);
                    })->where('status', 'Terverifikasi')
                      ->count();
            
                    $total = $bimbinganAktif + $mahasiswaLulus;
            
                    if ($total === 0) {
                        return '0%';
                    }
            
                    $presentase = ($mahasiswaLulus / $total) * 100;
            
                    return min(round($presentase), 100) . '%'; // <-- mentok 100%
                })
                ->badge()
                ->colors([
                    'danger' => fn ($state) => (int) $state < 50,
                    'warning' => fn ($state) => (int) $state >= 50 && (int) $state < 80,
                    'success' => fn ($state) => (int) $state >= 80,
                ])
                ->alignCenter(),
            
        ];
    }
}
