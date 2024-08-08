<?php

use jcobhams\NewsApi\NewsApi;

test('example', function () {
    $newsapi = new NewsApi($_ENV['NEWSAPI']);
    $sources = $newsapi->getSources(
        'business',
        'en',
        'us'
    );
    $response = $newsapi
        ->getTopHeadlines(
            'investment',
            $sources);
    $this->assertNotEmpty($response);
    $this->assertIsObject($response);
});
