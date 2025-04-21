<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-1 mb-5">
            <h1 class="text-xl font-bold">Halo, {{ auth()->user()->name }}!</h1>
            <h2 class="text-xl font-bold">Selamat Datang di Sistem Informasi Manajemen Skripsi</h2>
        </div>
        @if ($skripsi)
            <div class="space-y-2">
                <table>
                    <tr>
                        <td>Judul Skripsi</td>
                        <td>:</td>
                        <td><strong>{{ $skripsi->judul }}</strong></td>
                    </tr>
                    <tr>
                        <td>Pembimbing 1</td>
                        <td>:</td>
                        <td><strong>{{ $skripsi->dosen->name ?? 'Belum ditentukan' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Pembimbing 2</td>
                        <td>:</td>
                        <td><strong>{{ $skripsi->coDosen->name ?? '-' }}</strong></td>
                    </tr>
                </table>
            </div>
        @elseif (!$pernahMengajukan)
            <div class="space-y-4">
                <p>Silahkan mengisi outline judul skripsi pada bagian <strong>“Pengajuan Judul”</strong>.</p>
                <a href="{{ route('filament.mahasiswa.resources.pengajuan-judul.index') }}"
                    class="inline-block px-4 py-2 text-white bg-primary-600 hover:bg-primary-700 rounded-lg">
                    Ajukan Judul Sekarang
                </a>
            </div>
        @else
            <p class="text-sm text-gray-500">Pengajuan judul Anda sedang diproses. Mohon tunggu keputusan Program Studi.
            </p>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
