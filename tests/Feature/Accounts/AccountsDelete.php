<?php

use App\Models\Account;
use App\Models\User;
use function Pest\Laravel\assertDatabaseCount;

test('a user can create a private account', function () {
    [$user1, $user2] = User::factory(2)->create();
    $this->actingAs($user1)
        ->post('/accounts/create', [
            'currency' => 'USD',
            'type' => 'Private',
        ]);
    $this->actingAs($user2)
        ->post('/accounts/create', [
            'currency' => 'USD',
            'type' => 'Private',
        ]);
    $user1Account = Account::where('user_id', $user1->id)->first();
    $user2Account = Account::where('user_id', $user2->id)->first();
    assertDatabaseCount('accounts', 2);
    //assert deletion without transactions
    $user1Account->delete();
    assertDatabaseCount('accounts', 1);
    $this->actingAs($user1)
        ->post('/accounts/create', [
            'currency' => 'USD',
            'type' => 'Private',
        ]);
    assertDatabaseCount('accounts', 2);
    $user1Account = Account::where('user_id', $user1->id)->first();
    $user1Account->balance += 100;
    $user1Account->save();
    //creating transaction
    $response = $this->actingAs($user1)
        ->put('/transactions/create', [
            'amount' => '1',
            'from_account' => $user1->accounts()->first()->id,
            'contact' => null,
            'receiver_account' => $user2->accounts()->first()->id,
            'message' => 'Test Transaction'
        ]);
    $response->assertStatus(302);
    $response->assertSessionHas('success', 'Transaction sent successfully');
    $this->assertDatabaseCount('transactions', 2);
    assertDatabaseCount('accounts', 2);
    //asserting deletion with outgoing transaction
    $user1Account->delete();
    assertDatabaseCount('accounts', 1);
    //asserting deletion with incoming transaction
    $user2Account->delete();
    assertDatabaseCount('accounts', 0);
});
