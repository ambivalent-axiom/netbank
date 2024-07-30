<?php

use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\assertEquals;

test('Exchange rate is cached and exists in cache', function () {
    $rates = file_get_contents(__DIR__ . '/../Props/lb_bank_rates.xml');
    Cache::put('exchange_rates', $rates, 3600);
    assertEquals($rates, Cache::get('exchange_rates'));
});
