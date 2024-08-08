<?php

use App\Models\Account;
use App\Models\Currency;
use App\Models\Portfolio;
use App\Models\User;

test('can sell crypto currency', function () {
    $user = User::factory()->create();
    $account = Account::factory()
        ->create([
            'type' => 'investment',
            'currency' => 'USD',
            'user_id' => $user->id,
            'balance' => 100000
        ]);
    $currency = Currency::factory()
        ->create(
        [
            'type' => 'crypto',
            'symbol' => 'BTC',
            'rate' => 60,
            'name' => 'Bitcoin',
            'rank' => 1,
        ]
    );
    $portfolio = Portfolio::factory()
        ->create(
        [
            'portfolio_id' => $account->portfolio_id,
            'user_id' => $user->id,
            'symbol' => $currency->symbol,
            'currency_name' => $currency->name,
            'amount' => 10,
        ]
    );
    $response = $this->actingAs($user)
        ->put('/crypto/sell', [
            'currency_name' => $portfolio->currency_name,
            'currency_symbol' => $portfolio->symbol,
            'crypto_amount' => 5,
            'usd_amount' => 5 * $currency->rate,
        ]);

    $portfolio = $portfolio->where(
        [
            'portfolio_id' => $account->portfolio_id,
            'currency_name' => $currency->name,
            'symbol' => $currency->symbol,
        ]
    )->first();
    $this->assertEquals(5, $portfolio->amount);
    $account->refresh();
    $this->assertEquals(130000, $account->balance);
    $response->assertSessionHas('success', 'Crypto sell operation completed');
    $response->assertSessionHasNoErrors();
    $response->assertStatus(302);

});
