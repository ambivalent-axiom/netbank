<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'type' => 'private',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    $this->assertNotNull(auth()->user()->default_account);
    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
