<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchCryptoCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-crypto';

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
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-CMC_PRO_API_KEY' => $_ENV['COINMC'],
            ])->withQueryParameters(
                [
                    'start' => '1',
                    'limit' => '2000',
                    'convert' => 'USD'
                ]
            )->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest');
            $response = json_decode($response->body());
            $response = $response->data;
        } catch (Exception $e) {
            try {
                $response = Http::get('https://api.coinpaprika.com/v1/tickers');
                $response = json_decode($response->body());
            } catch (Exception $e) {
                throw new Exception('Failed to retrieve API data');
            }
        }
        foreach ($response as $currency) {
            Currency::updateOrCreate(
                [
                    'type' => 'crypto',
                    'symbol' => $currency->symbol,
                    'name' => $currency->name,
                ],
                [
                    'rate' => $currency->quotes->{'USD'}->price ?? $currency->quote->{'USD'}->price,
                    'rank' => $currency->cmc_rank ?? $currency->rank,
                    'percent_changed' => $currency->quotes->{'USD'}->percent_change_24h ?? $currency->quote->{'USD'}->percent_change_24h,
                ]
            );
        }
    }
}
