<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->apiUrl = env('STAGING_TRAKT_API_URL') . 'movies/';
    $this->headers = [
        'Content-type' => 'application/json',
        'trakt-api-version' => env('TRAKT_API_VERSION', '2'),
        'trakt-api-key' => env('STAGING_TRAKT_CLIENT_ID'),
    ];
});

it('can get a movie', function () {
    Http::fake();

    Http::withHeaders($this->headers)->get($this->apiUrl . 'pulp-fiction-1994');

    Http::assertSent(function (Request $request) {
        return $request->hasHeader('trakt-api-kasdadey') ;
    });
});
