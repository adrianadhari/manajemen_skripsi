<?php

namespace App\Filament\Admin\Resources\PenjadwalanSemproResource\Pages;

use App\Filament\Admin\Resources\PenjadwalanSemproResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;


class ManagePenjadwalanSempros extends ManageRecords
{
    protected static string $resource = PenjadwalanSemproResource::class;

    protected function getHeaderAction(): array
    {
        return [
        ];
    }
}
