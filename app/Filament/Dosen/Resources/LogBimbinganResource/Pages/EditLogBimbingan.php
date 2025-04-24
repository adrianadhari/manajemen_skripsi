<?php

namespace App\Filament\Dosen\Resources\LogBimbinganResource\Pages;

use App\Filament\Dosen\Resources\LogBimbinganResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditLogBimbingan extends EditRecord
{
    protected static string $resource = LogBimbinganResource::class;

    protected function getHeaderActions(): array
    {
        return [ 
        ];
    }
}
