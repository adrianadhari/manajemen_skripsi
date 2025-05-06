<?php

namespace App\Filament\Mahasiswa\Resources\PengajuanJudulResource\Pages;

use App\Filament\Mahasiswa\Resources\PengajuanJudulResource;
use App\Models\Skripsi;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ManageRecords;

class ManagePengajuanJuduls extends ManageRecords
{
    protected static string $resource = PengajuanJudulResource::class; //menghubungkan file ini dengan PengajuanJudulResource, supaya bisa ambil schema dan table yang sudah kamu definisikan di sana.


    protected function getHeaderActions(): array
    {
        $user = Filament::auth()->user();

        $skripsiDisetujuiExists = Skripsi::where('mahasiswa_id', $user->id)
            ->where('status', 'Disetujui')
            ->exists();

        return [
            Actions\CreateAction::make()
                ->label('Ajukkan Judul')
                ->modalHeading('Form Pengajuan Judul')
                ->modalSubmitActionLabel('Kirim')
                ->modalCancelAction(false)
                ->createAnother(false)
                ->visible(!$skripsiDisetujuiExists),
        ];
    }
}
