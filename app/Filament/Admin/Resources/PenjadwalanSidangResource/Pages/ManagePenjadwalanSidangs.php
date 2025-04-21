<?php

namespace App\Filament\Admin\Resources\PenjadwalanSidangResource\Pages;

use App\Filament\Admin\Resources\PenjadwalanSidangResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePenjadwalanSidangs extends ManageRecords
{
    protected static string $resource = PenjadwalanSidangResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
