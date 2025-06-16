<?php

namespace App\Filament\Dosen\Resources\MahasiswaBimbinganResource\Pages;

use App\Filament\Dosen\Resources\MahasiswaBimbinganResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMahasiswaBimbingans extends ManageRecords
{
    protected static string $resource = MahasiswaBimbinganResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
