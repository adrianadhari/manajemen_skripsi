<?php

namespace App\Filament\ProgramStudi\Resources\ProgresMahasiswaResource\Pages;

use App\Filament\ProgramStudi\Resources\ProgresMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProgresMahasiswas extends ManageRecords
{
    protected static string $resource = ProgresMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
