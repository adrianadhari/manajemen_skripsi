<?php

namespace App\Filament\Admin\Resources\VerifikasiMahasiswaResource\Pages;

use App\Filament\Admin\Resources\VerifikasiMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageVerifikasiMahasiswas extends ManageRecords
{
    protected static string $resource = VerifikasiMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
