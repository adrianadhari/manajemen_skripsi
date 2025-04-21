<?php

namespace App\Filament\Admin\Resources\PenjadwalanSemhasResource\Pages;

use App\Filament\Admin\Resources\PenjadwalanSemhasResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePenjadwalanSemhas extends ManageRecords
{
    protected static string $resource = PenjadwalanSemhasResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
