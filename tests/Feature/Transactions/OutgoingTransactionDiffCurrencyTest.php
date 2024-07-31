<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEquals;

test('Outgoing Transaction can be staged with currency exchange', function () {
    [$user1, $user2] = User::factory(2)->create();
    DB::table('currencies')->insert([
            'type' => 'fiat',
            'symbol' => 'USD',
            'rate' => '0.92'
        ]
    );
    DB::table('currencies')->insert([
            'type' => 'fiat',
            'symbol' => 'EUR',
            'rate' => '1'
        ]
    );
    DB::table('currencies')->insert([
            'type' => 'fiat',
            'symbol' => 'DKK',
            'rate' => '7.46'
        ]
    );
    $this->actingAs($user1)
        ->post('/accounts/create', [
            'currency' => 'DKK',
            'type' => 'Private',
        ]);
    $this->actingAs($user2)
        ->post('/accounts/create', [
            'currency' => 'USD',
            'type' => 'Private',
        ]);
    $senderAccount = Account::where('user_id', $user1->id)->first();
    $senderAccount->balance += 100;
    $receiverAccount = Account::where('user_id', $user2->id)->first();
    $senderAccount->save();
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
    $this->assertDatabaseHas('transactions', [
        'sender_id' => $user1->id,
        'recipient_id' => $user2->id,
        'sender_account_id' => $user1->accounts()->first()->id,
        'recipient_account_id' => $user2->accounts()->first()->id,
        'message' => 'Test Transaction'
    ]);
    $this->assertDatabaseCount('transactions', 2);
    $this->assertDatabaseHas('transactions', [
        'type' => 'incoming'
    ]);
    $this->assertDatabaseHas('transactions', [
        'status' => 'completed'
    ]);
    $senderAccount = $senderAccount->fresh();
    $receiverAccount = $receiverAccount->fresh();
    assertEquals(0, $senderAccount->balance);
    assertNotEquals(0, $receiverAccount->balance);
});
