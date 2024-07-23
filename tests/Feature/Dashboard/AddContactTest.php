<?php

use App\Models\User;

test('a user can add an contact', function () {
    [$user1, $user2] = User::factory(2)->create();
    $response = $this
        ->actingAs($user1)
        ->post('contacts/add', [
        'email' => $user2->email,
    ]);
    $this->assertCount(1, $user1->contacts);
    $this->assertAuthenticated();
    $response->assertRedirect(route('contacts.index'));
});


