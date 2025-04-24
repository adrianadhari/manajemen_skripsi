<?php

namespace App\Filament\Mahasiswa\Resources\BimbinganResource\Pages;

use App\Filament\Mahasiswa\Resources\BimbinganResource;
use App\Models\Skripsi;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ManageRecords;

class ManageBimbingans extends ManageRecords
{
    protected static string $resource = BimbinganResource::class;

    protected function getHeaderActions(): array
    {
        $user = Filament::auth()->user();

        $skripsiDisetujuiExists = Skripsi::where('mahasiswa_id', $user->id)
            ->where('status', 'Disetujui')
            ->exists();

        return [
            Actions\CreateAction::make()
                ->label('Buat Log Bimbingan')
                ->modalHeading('Form Log Bimbingan')
                ->modalSubmitActionLabel('Buat')
                ->modalCancelAction(false)
                ->createAnother(false)
                ->visible($skripsiDisetujuiExists),
        ];
    }
}
