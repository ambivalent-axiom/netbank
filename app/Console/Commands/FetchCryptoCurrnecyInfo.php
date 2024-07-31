<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchCryptoCurrnecyInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-crypto-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $currencies = Currency::where('type', 'crypto')
            ->whereNull('logo')
            ->get();
        foreach ($currencies as $currency) {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-CMC_PRO_API_KEY' => $_ENV['COINMC'],
            ])->get('https://pro-api.coinmarketcap.com/v2/cryptocurrency/info?symbol=' . $currency->symbol);
            var_dump(json_decode($response->body()));
            $response = json_decode($response->body());
            $currency->logo = $response->data->{strtoupper($currency->symbol)}[0]->logo;
            $currency->save();
            sleep(3);
        }
    }
}
