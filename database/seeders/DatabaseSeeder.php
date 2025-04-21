<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'no_induk' => '00000000',
            'password' => Hash::make('12345678'),
            'role' => 'Admin'
        ]);
        User::create([
            'name' => 'Rizka Adityani',
            'email' => 'rizkaadityani@gmail.com',
            'no_induk' => '212210006',
            'password' => Hash::make('12345678'),
            'role' => 'Mahasiswa'
        ]);
        User::create([
            'name' => 'Yanto Hermawan',
            'email' => 'yantohermawan@email.com',
            'no_induk' => '000666000',
            'password' => Hash::make('12345678'),
            'role' => 'Dosen'
        ]);
        User::create([
            'name' => 'Pingky Dezar',
            'email' => 'pingkydezar@email.com',
            'no_induk' => '000999000',
            'password' => Hash::make('12345678'),
            'role' => 'Program Studi'
        ]);
    }
}
