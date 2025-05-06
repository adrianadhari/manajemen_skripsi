<?php

namespace App\Filament\Admin\Resources\VerifikasiMahasiswaResource\Pages;

use App\Filament\Admin\Resources\VerifikasiMahasiswaResource;
use Filament\Actions;
use App\Models\UjianSkripsi;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;

class ManageVerifikasiMahasiswas extends ManageRecords
{
    protected static string $resource = VerifikasiMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    public function mount(): void
    {
        parent::mount();

        if (UjianSkripsi::where('status', 'Menunggu Verifikasi')->exists()) {
            Notification::make()
                ->title('Ada Mahasiswa Menunggu Verifikasi')
                ->body('Segera verifikasi pendaftaran mahasiswa yang baru.')
                ->icon('heroicon-o-bell-alert')
                ->iconColor('warning')
                ->send();
        }
    }
}
