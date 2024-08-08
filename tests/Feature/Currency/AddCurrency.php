<?php

use App\Models\Currency;

test('add currency', function () {
    $currency = Currency::factory()->create();
    $this->assertDatabaseCount('currencies',1);
});
