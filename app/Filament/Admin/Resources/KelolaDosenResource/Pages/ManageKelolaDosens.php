<?php

namespace App\Filament\Admin\Resources\KelolaDosenResource\Pages;

use App\Filament\Admin\Resources\KelolaDosenResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKelolaDosens extends ManageRecords
{
    protected static string $resource = KelolaDosenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
