<?php

use App\Models\User;

test('a user can delete an contact', function () {
    [$user1, $user2] = User::factory(2)->create();

    $this->assertDatabaseMissing('user_contacts', [
        'user_id' => $user1->id,
        'contact_user_id' => $user2->id,
    ]);

    $this->actingAs($user1)->post('contacts/add',
        ['email' => $user2->email]);

    $this->assertDatabaseHas('user_contacts', [
        'user_id' => $user1->id,
        'contact_user_id' => $user2->id,
    ]);

    $response = $this->actingAs($user1)->delete('/contacts/delete',
        ['contact' => $user2->id]);

    $this->assertDatabaseMissing('user_contacts', [
        'user_id' => $user1->id,
        'contact_user_id' => $user2->id,
    ]);
    $response->assertRedirect(route('contacts.index'));
});
