<?php

namespace App\Filament\Dosen\Resources\LogBimbinganResource\Pages;

use App\Filament\Dosen\Resources\LogBimbinganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLogBimbingans extends ListRecords
{
    protected static string $resource = LogBimbinganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
