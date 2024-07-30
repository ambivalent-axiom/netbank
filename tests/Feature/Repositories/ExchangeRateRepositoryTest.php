<?php

use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\assertEquals;

test('LV bank resource is available and free', function () {
    $response = Http::get('https://www.bank.lv/vk/ecb.xml');
    assertEquals('200', $response->status());
});
