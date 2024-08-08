<?php

use App\Models\Account;
use App\Models\Currency;
use App\Models\User;

test('User message Transaction is properly recorded and delivered to user', function () {
    [$user1, $user2] = User::factory(2)->create();
    $currency = Currency::factory()
        ->create(
            [
                'type' => 'fiat',
                'symbol' => 'EUR',
                'rate' => 1
            ]
        );
    $this->actingAs($user1)
        ->post('/accounts/create', [
            'currency' => 'EUR',
            'type' => 'Private',
        ]);
    $this->actingAs($user2)
        ->post('/accounts/create', [
            'currency' => 'EUR',
            'type' => 'Private',
        ]);
    $senderAccount = Account::where('user_id', $user1->id)->first();
    $senderAccount->balance += 100;
    $senderAccount->save();
    $response = $this->actingAs($user1)
        ->put('/transactions/create', [
            'amount' => '1',
            'from_account' => $user1->accounts()->first()->id,
            'contact' => null,
            'receiver_account' => $user2->accounts()->first()->id,
            'message' => 'Test Transaction'
        ]);
    $response->assertSessionHas('success', 'Transaction sent successfully');
    $this->assertDatabaseHas('user_messages', [
        'user_id' => $user1->id,
        'message' => $user2->first_name . ' ' . $user2->last_name . ' has received Your money transfer - Test Transaction',
    ]);
    $response = $this->actingAs($user1)
        ->get('/dashboard');

    $response->assertSee($user2->first_name . ' ' . $user2->last_name . ' has received Your money transfer - Test Transaction');
});
