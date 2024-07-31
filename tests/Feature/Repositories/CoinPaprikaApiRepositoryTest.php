<?php

use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\assertEquals;

test('Check CoinPaprika connectivity', function () {
    $response = Http::get('https://api.coinpaprika.com/v1/tickers?limit=10');
    assertEquals('200', $response->status());
});
