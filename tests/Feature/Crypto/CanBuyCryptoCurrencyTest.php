<?php

use App\Models\Account;
use App\Models\Currency;
use App\Models\User;

test('can buy crypto currency', function () {
    $user = User::factory()->create();
    $account = Account::factory()
        ->create([
            'type' => 'investment',
            'currency' => 'USD',
            'user_id' => $user->id,
            'balance' => 100000
        ]);
    $currencies = Currency::factory(150)->create();
    $cryptoCurrencies = $currencies->filter(function ($currency) {
        return $currency->type === 'crypto';
    });
    $currency = $cryptoCurrencies->random();
    $response = $this->actingAs($user)
        ->put('/crypto/buy/' . $currency->name, [
            'currency_name' => $currency->name,
            'currency_symbol' => $currency->symbol,
            'usd_amount' => 100,
            'crypto_amount' => $currency->rate * 100
        ]);
    $this->assertDatabaseHas('portfolios', [
        'user_id' => $user->id,
        'symbol' => $currency->symbol,
    ]);
    $response->assertStatus(302);
});
