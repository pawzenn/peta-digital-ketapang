<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminResetPassword extends Command
{
    protected $signature = 'admin:reset-password
                            {email? : Email akun admin}
                            {--nama=Admin Ketapang : Nama, dipakai hanya saat akun baru dibuat}
                            {--password= : Password (tidak disarankan: terekam di riwayat terminal)}';

    protected $description = 'Buat akun admin baru, atau reset password admin yang lupa';

    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Email admin');

        $emailCheck = Validator::make(['email' => $email], ['email' => ['required', 'email', 'max:255']]);
        if ($emailCheck->fails()) {
            $this->error('Email tidak valid.');

            return self::FAILURE;
        }

        $generated = false;
        $password = $this->option('password');

        if (! $password) {
            $this->line('Ketik password baru (minimal 12 karakter), atau kosongkan lalu Enter untuk dibuatkan password acak.');
            $password = (string) $this->secret('Password');

            if ($password === '') {
                $password = Str::password(20, symbols: false);
                $generated = true;
            } elseif ($password !== (string) $this->secret('Ulangi password')) {
                $this->error('Password tidak sama. Tidak ada yang diubah.');

                return self::FAILURE;
            }
        }

        if (mb_strlen($password) < 12) {
            $this->error('Password minimal 12 karakter. Tidak ada yang diubah.');

            return self::FAILURE;
        }

        $user = User::where('email', $email)->first();
        $baru = $user === null;

        $user ??= new User(['email' => $email, 'name' => $this->option('nama')]);
        $user->password = $password; // di-hash otomatis oleh cast 'hashed'
        $user->save();

        $this->info($baru ? "Akun admin dibuat: {$email}" : "Password admin diganti: {$email}");

        if ($generated) {
            $this->newLine();
            $this->warn('Password acak (hanya tampil SEKALI, simpan di password manager):');
            $this->line($password);
        }

        return self::SUCCESS;
    }
}
