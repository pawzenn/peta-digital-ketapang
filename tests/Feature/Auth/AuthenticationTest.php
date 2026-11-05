<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/' . config('app.admin_path'));

    $response->assertStatus(200);
});

test('old admin and login urls do not exist', function () {
    $this->get('/admin')->assertNotFound();
    $this->get('/admin/login')->assertNotFound();
    $this->get('/login')->assertNotFound();
});

test('forgot password pages do not exist', function () {
    $this->get('/forgot-password')->assertNotFound();
    $this->get('/reset-password/abc')->assertNotFound();
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/' . config('app.admin_path'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('admin.dashboard'));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/' . config('app.admin_path'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect(route('login'));
});
