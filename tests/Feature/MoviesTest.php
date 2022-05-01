<?php


beforeEach(function () {
    $this->apiUrl = env('STAGING_TRAKT_API_URL') . 'movies/';
    $this->headers = [
        'Content-type' => 'application/json',
        'trakt-api-version' => env('TRAKT_API_VERSION', '2'),
        'trakt-api-key' => env('STAGING_TRAKT_CLIENT_ID'),
    ];
});
