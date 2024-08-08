<?php

use App\Models\Currency;
use Illuminate\Support\Facades\DB;

test('check That no duplicates created', function () {
    $currencies = Currency::factory(150)->create();
    $duplicateCodes = DB::table('currencies')
        ->select('name')
        ->groupBy('name')
        ->havingRaw('COUNT(name) > 1')
        ->pluck('name');
    $this->assertEmpty($duplicateCodes);
});
