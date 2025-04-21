<?php

namespace App\Filament\Admin\Resources\KelolaMahasiswaResource\Pages;

use App\Filament\Admin\Resources\KelolaMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKelolaMahasiswas extends ManageRecords
{
    protected static string $resource = KelolaMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
