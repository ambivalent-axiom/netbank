<?php

namespace App\Console\Commands;

use App\Models\NewsArticle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
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
        $newsapi = new NewsApi($_ENV['NEWSAPI']);
        $sources = $newsapi->getSources(
            'business',
            'en',
            'us'
        );
        $top_headlines = $newsapi
            ->getTopHeadlines(
                'finance',
                $sources);
        foreach ($top_headlines->articles as $article) {
            NewsArticle::updateOrCreate(
                [
                    'source' => $article->source->name,
                    'title' => $article->title,
                ],
                [
                    'author' => $article->author,
                    'url' => $article->url,
                    'description' => $article->description,
                    'content' => $article->content,
                    'image' => $article->urlToImage,
                    'published_at' => $article->publishedAt,
                ]
            );
        }
    }
}
