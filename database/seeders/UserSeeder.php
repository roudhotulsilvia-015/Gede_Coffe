<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Admin
        User::create([
            'name' => 'Admin GedeCoffee',
            'username' => 'admin',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Membuat Kasir
        User::create([
            'name' => 'Kasir GedeCoffee',
            'username' => 'kasir',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
        ]);
    }
}