<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Akun bawaan ini berpassword umum, hanya untuk komputer lokal.
        // Di server produksi pakai: php artisan admin:reset-password
        if (app()->isProduction()) {
            $this->command?->error('AdminSeeder dinonaktifkan di produksi. Gunakan: php artisan admin:reset-password');

            return;
        }

        User::updateOrCreate(
            ['email' => 'admin@ketapang.test'],
            [
                'name' => 'Admin Ketapang',
                'password' => Hash::make('password'),
            ]
        );
    }
}
