<?php

namespace App\Filament\Dosen\Widgets;

use Filament\Widgets\Widget;

class Welcome extends Widget
{
    protected static string $view = 'filament.dosen.widgets.welcome';
    protected int | string | array $columnSpan = 'full';
}
