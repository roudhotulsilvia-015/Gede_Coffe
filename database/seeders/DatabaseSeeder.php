<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Seeder untuk mengisi database dengan data awal, termasuk pembuatan pengguna default.
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    
    public function run(): void
    {
        // Membuat pengguna default dengan nama "Test User" dan email "
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
