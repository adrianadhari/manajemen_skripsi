<?php

namespace App\Filament\ProgramStudi\Resources\ApprovePenjadwalanUjianResource\Pages;

use App\Filament\ProgramStudi\Resources\ApprovePenjadwalanUjianResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageApprovePenjadwalanUjians extends ManageRecords
{
    protected static string $resource = ApprovePenjadwalanUjianResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
