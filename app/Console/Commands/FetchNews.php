<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use jcobhams\NewsApi\NewsApi;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news';

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
        $newsapi = new NewsApi($_ENV('NEWSAPI'));
        $language = 'en';
        $country = 'us';
        $sources = $newsapi
            ->getSources(
                "business",
                $language,
                $country
            );
        $top_headlines = $newsapi
            ->getTopHeadlines(
            'crypto',
            $sources,
            $country,
                "business",
            20,
            2);
    }
}
