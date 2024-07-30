<?php

use App\Models\Account;
use App\Models\User;

test('a user can create a private account', function () {
    $user = User::factory()->create();
    $response = $this
        ->actingAs($user)
        ->post('/accounts/create', [
            'currency' => 'USD',
            'type' => 'Private',
        ]);
    $response->assertStatus(302);
    $this->assertDatabaseHas('accounts', [
        'user_id' => $user->id
    ]);
});
