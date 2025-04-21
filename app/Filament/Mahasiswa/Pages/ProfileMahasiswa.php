<?php

namespace App\Filament\Mahasiswa\Pages;

use Filament\Pages\Page;

class ProfileMahasiswa extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Profil Saya';
    protected static ?string $title = 'Profil Saya';
    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.mahasiswa.pages.profile-mahasiswa';

    public $user;

    public function mount(): void
    {
        $this->user = auth()->user();
    }
}
