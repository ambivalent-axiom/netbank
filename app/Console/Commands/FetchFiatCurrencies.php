<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FetchFiatCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-fiat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://www.bank.lv/vk/ecb.xml');
        $xml = simplexml_load_string($response->body());
        foreach ($xml->Currencies->Currency as $currency) {
            Currency::updateOrCreate(
                [
                    'symbol' => $currency->ID,
                    'type' => 'fiat',
                ],
                [
                    'rate' => $currency->Rate
                ]
            );
        }
        Currency::updateOrCreate(
            [
                'symbol' => 'EUR',
                'type' => 'fiat',
            ],
            [
                'rate' => '1'
            ]
        );
    }
}
