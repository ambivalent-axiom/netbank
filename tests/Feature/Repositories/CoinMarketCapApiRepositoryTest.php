<?php

use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\assertEquals;

test('Check CoinMarketCap connectivity', function () {
    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'X-CMC_PRO_API_KEY' => $_ENV['COINMC'],
    ])->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?limit=10');
    assertEquals('200', $response->status());
});
