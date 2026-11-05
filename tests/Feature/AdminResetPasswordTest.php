<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('membuat akun admin baru', function () {
    $this->artisan('admin:reset-password', ['email' => 'baru@desa.test', '--password' => 'PasswordKuat12345'])
        ->expectsOutputToContain('Akun admin dibuat')
        ->assertExitCode(0);

    $user = User::where('email', 'baru@desa.test')->first();
    expect($user)->not->toBeNull()
        ->and(Hash::check('PasswordKuat12345', $user->password))->toBeTrue();
});

test('mengganti password admin yang sudah ada', function () {
    $user = User::factory()->create(['email' => 'lama@desa.test', 'password' => 'PasswordLama12345']);

    $this->artisan('admin:reset-password', ['email' => 'lama@desa.test', '--password' => 'PasswordBaru12345'])
        ->expectsOutputToContain('Password admin diganti')
        ->assertExitCode(0);

    expect(Hash::check('PasswordBaru12345', $user->fresh()->password))->toBeTrue();
    expect(User::count())->toBe(1);
});

test('menolak password pendek dan email tidak valid', function () {
    $this->artisan('admin:reset-password', ['email' => 'a@desa.test', '--password' => 'pendek'])->assertExitCode(1);
    $this->artisan('admin:reset-password', ['email' => 'bukan-email', '--password' => 'PasswordKuat12345'])->assertExitCode(1);

    expect(User::count())->toBe(0);
});
