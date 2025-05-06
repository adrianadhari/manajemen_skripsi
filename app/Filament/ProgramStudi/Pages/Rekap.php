<?php

namespace App\Filament\ProgramStudi\Pages;

use App\Models\Skripsi;
use App\Models\UjianSkripsi;
use App\Models\RekapSkripsi;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;

class Rekap extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationLabel = 'Rekap';
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = null;

    protected static string $view = 'filament.program-studi.pages.rekap';

    protected function getTableQuery()
    {
        return RekapSkripsi::query()->whereRaw('1 = 0'); // <-- Tambah ini
    }

    public function getTableRecords(): Collection
    {
        return RekapSkripsi::hydrate([
            ['id' => 1, 'status' => 'Pengajuan Judul', 'jumlah' => Skripsi::where('status', 'Pengajuan Judul')->count()],
            ['id' => 2, 'status' => 'Dalam Bimbingan', 'jumlah' => Skripsi::where('status', 'Sedang Dibimbing')->count()],
            ['id' => 3, 'status' => 'Seminar Proposal', 'jumlah' => UjianSkripsi::where('jenis_ujian', 'Seminar Proposal')->where('status', 'Terverifikasi')->count()],
            ['id' => 4, 'status' => 'Seminar Hasil', 'jumlah' => UjianSkripsi::where('jenis_ujian', 'Seminar Hasil')->where('status', 'Terverifikasi')->count()],
            ['id' => 5, 'status' => 'Sidang Skripsi', 'jumlah' => UjianSkripsi::where('jenis_ujian', 'Sidang Skripsi')->where('status', 'Terverifikasi')->count()],
        ]);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('status')
                ->label('Status Mahasiswa')
                ->alignLeft()
                ->badge()
                ->colors([
                    'info',
                    'success' => fn ($state) => str_contains($state, 'Selesai'),
                ]),

            TextColumn::make('jumlah')
                ->label('Jumlah')
                ->alignCenter(),
        ];
    }
}
