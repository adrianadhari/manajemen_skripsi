<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIMASI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    {{-- Navbar --}}
    <nav class="bg-white h-20 shadow-lg w-full fixed top-0">
        <div class="container mx-auto h-full flex items-center justify-between">
            <div>
                <a href="/" class="text-[#003F88] text-3xl font-bold">SIMASI</a>
            </div>
            <div>
                <a href="{{ route('login') }}" class="bg-[#FFCC00] px-8 py-2 rounded-lg font-semibold">Login</a>
            </div>
        </div>
    </nav>
    {{-- Navbar --}}


    {{-- Hero --}}
    <section class="hero min-h-[100vh] bg-[#EEF4FA] w-full pt-20 flex items-center">
        <div class="container mx-auto flex justify-between items-center">
            <div class="space-y-6">
                <p class="text-xl font-semibold">Selamat Datang di</p>
                <p class="text-[#003F88] font-extrabold text-5xl leading-normal">Sistem Informasi Manajemen Skripsi
                    Program Studi Sistem Informasi</p>
                <p class="text-lg">Kelola seluruh proses skripsi dari pengajuan judul, seminar,
                    hingga sidang dalam satu sistem terintegrasi.</p>
            </div>
            <div class="max-w-2xl">
                <div class="bg-white p-11 rounded-3xl">
                    <img src="{{ asset('images/ibik-building.png') }}" alt="IBIK Building" class="w-full">
                </div>
            </div>
        </div>
    </section>
    {{-- Hero --}}


    {{-- Fitur --}}
    <section class="container mx-auto bg-white w-full py-20">
        <p class="text-[#003F88] font-extrabold text-5xl">Fitur</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-24 gap-y-14 mt-6">
            <div class="rounded-2xl p-9 border border-[#003F88] space-y-3">
                <p class="text-[#003F88] font-bold text-3xl">Pengajuan Judul</p>
                <p class="font-medium text-lg">Meningkatkan perjalanan akademis Anda dengan fitur
                    'Pengajuan Judul' karena setiap penelitian hebat dimulai
                    dengan judul yang baik</p>
                <div class="flex items-center justify-end">
                    <a href="#" class=" text-[#FFCC00] font-medium text-lg">Lihat Selengkapnya
                    </a>
                    <x-heroicon-o-chevron-right class="h-6 w-6 text-gray-500" />
                </div>
            </div>
            <div class="rounded-2xl p-9 border border-[#003F88] space-y-3">
                <p class="text-[#003F88] font-bold text-3xl">Kontrol Skripsi</p>
                <p class="font-medium text-lg">Meningkatkan perjalanan akademis Anda dengan fitur
                    'Pengajuan Judul' karena setiap penelitian hebat dimulai
                    dengan judul yang baik</p>
                <div class="flex items-center justify-end">
                    <a href="#" class=" text-[#FFCC00] font-medium text-lg">Lihat Selengkapnya
                    </a>
                    <x-heroicon-o-chevron-right class="h-6 w-6 text-gray-500" />
                </div>
            </div>
            <div class="rounded-2xl p-9 border border-[#003F88] space-y-3">
                <p class="text-[#003F88] font-bold text-3xl">Bimbingan Online</p>
                <p class="font-medium text-lg">Meningkatkan perjalanan akademis Anda dengan fitur
                    'Pengajuan Judul' karena setiap penelitian hebat dimulai
                    dengan judul yang baik</p>
                <div class="flex items-center justify-end">
                    <a href="#" class=" text-[#FFCC00] font-medium text-lg">Lihat Selengkapnya
                    </a>
                    <x-heroicon-o-chevron-right class="h-6 w-6 text-gray-500" />
                </div>
            </div>
            <div class="rounded-2xl p-9 border border-[#003F88] space-y-3">
                <p class="text-[#003F88] font-bold text-3xl">Penjadwalan Seminar dan Sidang</p>
                <p class="font-medium text-lg">Meningkatkan perjalanan akademis Anda dengan fitur
                    'Pengajuan Judul' karena setiap penelitian hebat dimulai
                    dengan judul yang baik</p>
                <div class="flex items-center justify-end">
                    <a href="#" class=" text-[#FFCC00] font-medium text-lg">Lihat Selengkapnya
                    </a>
                    <x-heroicon-o-chevron-right class="h-6 w-6 text-gray-500" />
                </div>
            </div>
        </div>
    </section>
    {{-- Fitur --}}


    {{-- Footer --}}
    <footer class="bg-[#EEF4FA] py-20 w-full">
        <div class="container mx-auto flex items-center justify-between">
            <div class="space-y-10">
                <img src="{{ asset('images/logo.png') }}" alt="Logo IBIK">
                <p class="text-[#003F88] font-extrabold text-5xl">Need Help</p>
                <p class="text-[#003F88] font-semibold text-7xl">with anything?</p>
                <div class="flex">
                    <x-heroicon-o-map-pin class="h-6 w-6 text-gray-500" />
                    <p class="font-semibold">Rangga Gading No.01, Gudang, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat
                        16123</p>
                </div>
            </div>
            <p class="text-[#003F88] font-extrabold text-5xl">Contact Us</p>
        </div>
    </footer>

    <section class="w-full py-5 container mx-auto">
        <p class="text-end">Copyright &copy; <?= date('Y') ?> </p>
    </section>
    {{-- Footer --}}
</body>

</html>
