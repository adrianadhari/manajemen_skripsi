<?php

namespace App\Filament\Mahasiswa\Widgets;

use App\Models\Skripsi;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class InfoSkripsiWidget extends Widget
{
    protected static string $view = 'filament.mahasiswa.widgets.info-skripsi-widget';
    protected int | string | array $columnSpan = 'full';

    public function skripsiDisetujui()
    {
        return Skripsi::with('dosen')
            ->where('mahasiswa_id', Auth::id())
            ->where('status', 'Disetujui')
            ->first();
    }

    public function skripsiPernahDiajukan()
    {
        return Skripsi::where('mahasiswa_id', Auth::id())->exists();
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view(static::$view, [
            'skripsi' => $this->skripsiDisetujui(),
            'pernahMengajukan' => $this->skripsiPernahDiajukan(),
        ]);
    }
}
