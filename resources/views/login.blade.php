<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIMASI | Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="flex items-center w-full min-h-screen">
        <div class="w-1/2">
            <img src="{{ asset('images/login.png') }}" alt="Building IBIK" class="w-full max-h-screen">
        </div>
        <div class="p-24 w-1/2">
            <div class="flex items-center space-x-4 justify-center">
                <p class="text-[#003F88] text-3xl font-bold">SIMASI</p>
                <span class="border-2 border-[#003F88] h-10"></span>
                <div>
                    <p class="text-[#003F88] font-bold">Sistem Informasi Manajemen Skripsi</p>
                    <p class="text-[#003F88] font-bold">Program Studi Sistem Informasi</p>
                </div>
            </div>

            <form action="{{ route('login') }}" method="POST" class="max-w-lg mx-auto mt-8 space-y-7">
                @csrf
                <input type="text" name="no_induk" class="p-4 w-full border border-gray-600" placeholder="No. Induk">
                <input type="password" name="password" class="p-4 w-full border border-gray-600" placeholder="Password">
                <button type="submit"
                    class="p-4 w-full font-medium bg-[#FFCC00] cursor-pointer text-center">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
