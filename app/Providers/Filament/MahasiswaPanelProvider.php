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

class MahasiswaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('mahasiswa')
            ->path('mahasiswa') //mahaisswa akan mengakses dashboard di url/mahasiswa
            ->theme(asset('css/filament/mahasiswa/theme.css')) //theme custom pakai tailwind
            ->darkMode(false) //kalau mau terang ya ubah jadi true
            ->colors([
                'primary' => "#003F88", //set warna utama jadi biru.
            ])
            ->discoverResources(in: app_path('Filament/Mahasiswa/Resources'), for: 'App\\Filament\\Mahasiswa\\Resources') //Otomatis mencari resource ( model dan tabel data) 
            ->discoverPages(in: app_path('Filament/Mahasiswa/Pages'), for: 'App\\Filament\\Mahasiswa\\Pages') //Sama seperti di atas, tapi untuk halaman statis seperti dashboard custom
            ->pages([
                Pages\Dashboard::class, //menambahkan halaman dashboard bawaan dari Filament.
            ])
            ->discoverWidgets(in: app_path('Filament/Mahasiswa/Widgets'), for: 'App\\Filament\\Mahasiswa\\Widgets') //mencari widget khusus mahasiswa
            ->widgets([])
            ->middleware([
                EncryptCookies::class, //Mengenkripsi cookie
                AddQueuedCookiesToResponse::class, //AddQueuedCookiesToResponse → 
                StartSession::class, //Menjalankan sesi pengguna
                AuthenticateSession::class, //otentikasi sesi
                ShareErrorsFromSession::class, //Menyediakan error dari session (buat validasi)
                VerifyCsrfToken::class, //Melindungi dari serangan CSRF
                SubstituteBindings::class, //Mengatur route model binding
                DisableBladeIconComponents::class, // Menonaktifkan ikon blade (khusus Filament)
                DispatchServingFilamentEvent::class, //Men-trigger event saat panel diload
                CheckRole::class . ':Mahasiswa', //memastikan hanya Mahasiswa yang bisa akses
            ])
            ->authMiddleware([
                Authenticate::class, //otentikasi standar Laravel, memastikan hanya user yang sudah login yang bisa masuk.
            ]);
    }
}
