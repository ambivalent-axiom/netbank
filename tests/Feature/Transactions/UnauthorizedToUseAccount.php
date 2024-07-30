<?php
use App\Models\Account;
use App\Models\User;

test('User should be able to transact only with his accounts', function () {
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
    $user2Account = Account::where('user_id', $user2->id)->first();
    $user2Account->balance += 100;
    $user2Account->save();

    $response = $this->actingAs($user1)
        ->put('/transactions/create', [
            'amount' => '1',
            'from_account' => $user2->accounts()->first()->id,
            'contact' => null,
            'receiver_account' => $user1->accounts()->first()->id,
            'message' => 'Test Transaction'
        ]);
    $response->assertStatus(302);
    $this->assertDatabaseEmpty('transactions');
    $response->assertSessionHas('error', 'Unauthorized Transaction');
});
