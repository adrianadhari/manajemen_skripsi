<?php

namespace App\Filament\Dosen\Widgets;

use App\Models\UjianSkripsi;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class JadwalMenguji extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                UjianSkripsi::query()
                    ->with(['skripsi.mahasiswa'])
                    ->where(function ($query) {
                        $query->where('penguji_1_id', auth()->id())
                            ->orWhere('penguji_2_id', auth()->id());
                    })
                    ->whereNotNull('tanggal_seminar')
                    ->where('is_schedule_approved_by_prodi', true)
            )
            ->columns([
                TextColumn::make('jenis_ujian')->label('Jenis Ujian'),
                TextColumn::make('skripsi.mahasiswa.name')->label('Nama Mahasiswa'),
                TextColumn::make('skripsi.mahasiswa.no_induk')->label('NPM'),
                TextColumn::make('tanggal_seminar')->label('Tanggal')->date(),
                TextColumn::make('waktu_seminar')->label('Waktu')->time(),
                TextColumn::make('ruangan')->label('Ruangan'),
            ]);
    }
}
