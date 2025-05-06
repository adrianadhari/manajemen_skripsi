<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use App\Filament\Admin\Widgets\StatistikMahasiswa;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';


    
    protected function getHeaderWidgets(): array
    {
        return [
            StatistikMahasiswa::class,
        ];
    }
}
