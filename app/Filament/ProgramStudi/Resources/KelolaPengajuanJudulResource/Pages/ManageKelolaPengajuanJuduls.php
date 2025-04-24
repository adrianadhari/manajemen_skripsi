<?php

namespace App\Filament\ProgramStudi\Resources\KelolaPengajuanJudulResource\Pages;

use App\Filament\ProgramStudi\Resources\KelolaPengajuanJudulResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKelolaPengajuanJuduls extends ManageRecords
{
    protected static string $resource = KelolaPengajuanJudulResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
