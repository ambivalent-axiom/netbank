<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use function Pest\Laravel\assertDatabaseCount;

test('Can create account with other currencies besides EUR and USD', function () {
    $user = User::factory()->create();
    DB::table('currencies')->insert([
            'type' => 'fiat',
            'symbol' => 'DKK',
            'rate' => '7.46'
        ]
    );
    $response = $this->actingAs($user)
        ->post('/accounts/create', [
            'currency' => 'DKK',
            'type' => 'Private',
        ]);
    $response->assertStatus(302);
    assertDatabaseCount('accounts', 1);
});
