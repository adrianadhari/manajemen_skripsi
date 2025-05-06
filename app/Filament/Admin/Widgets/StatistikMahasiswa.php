<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\User;
use App\Models\UjianSkripsi;

class StatistikMahasiswa extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Jumlah Dosen', User::where('role', 'dosen')->count())
                ->description('Total dosen yang terdaftar')
                ->color('primary'),

            Card::make('Jumlah Mahasiswa', User::where('role', 'mahasiswa')->count())
                ->description('Total mahasiswa yang terdaftar')
                ->color('success'),

            // Hapus is_verified, karena di database gak ada kolom itu

            Card::make('Pendaftaran Seminar Proposal', UjianSkripsi::where('jenis_ujian', 'Seminar Proposal')->count())
                ->description('Total daftar Seminar Proposal')
                ->color('warning'),

            Card::make('Pendaftaran Seminar Hasil', UjianSkripsi::where('jenis_ujian', 'Seminar Hasil')->count())
                ->description('Total daftar Seminar Hasil')
                ->color('warning'),

            Card::make('Pendaftaran Sidang Skripsi', UjianSkripsi::where('jenis_ujian', 'Sidang Skripsi')->count())
                ->description('Total daftar Sidang Skripsi')
                ->color('danger'),
        ];
    }
}
