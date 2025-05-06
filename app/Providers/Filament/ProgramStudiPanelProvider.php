<?php

namespace App\Providers\Filament;

use App\Http\Middleware\CheckRole;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ProgramStudiPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->theme(asset('css/filament/mahasiswa/theme.css'))
            ->id('program-studi')
            ->path('program-studi')
            ->darkMode(false)
            ->colors([
                'primary' => "#003F88",
            ])
            ->discoverResources(in: app_path('Filament/ProgramStudi/Resources'), for: 'App\\Filament\\ProgramStudi\\Resources')
            ->discoverPages(in: app_path('Filament/ProgramStudi/Pages'), for: 'App\\Filament\\ProgramStudi\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/ProgramStudi/Widgets'), for: 'App\\Filament\\ProgramStudi\\Widgets')
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                CheckRole::class . ':Program Studi'
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
