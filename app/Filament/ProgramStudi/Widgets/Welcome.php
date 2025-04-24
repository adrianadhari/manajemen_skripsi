<?php

namespace App\Filament\ProgramStudi\Widgets;

use Filament\Widgets\Widget;

class Welcome extends Widget
{
    protected static string $view = 'filament.program-studi.widgets.welcome';
    protected int | string | array $columnSpan = 'full';
}
