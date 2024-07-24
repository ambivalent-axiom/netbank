<?php

use App\Models\User;

test('a user can share an account', function () {
    [$user1, $user2] = User::factory(2)->create();
    $response = $this
        ->actingAs($user1)
        ->post('contacts/add', [
            'email' => $user2->email,
        ]);
    $this->assertDatabaseHas('user_contacts', [
        'user_id' => $user1->id,
        'contact_user_id' => $user2->id,
    ]);
    $response = $this
        ->actingAs($user1)
        ->post('/accounts/create', [
            'currency' => 'USD',
            'type' => 'Shared',
        ]);
    $response->assertStatus(302);
    $this->assertDatabaseHas('accounts', [
        'user_id' => $user1->id
    ]);
    $response = $this
        ->actingAs($user1)
        ->put('accounts/share', [
            'contact' => $user2->id,
            'account' => $user1->accounts->first()->id,
        ]);
    $response->assertStatus(302);
    $this->assertDatabaseHas('shared_accounts', [
        'user_id' => $user1->id
    ]);
});
