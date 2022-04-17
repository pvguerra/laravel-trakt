<?php

return [
    'api_url' => env('TRAKT_API_URL'),

    'api_url_mock' => env('TRAKT_API_URL_MOCK'),

    'client_id' => env('TRAKT_CLIENT_ID'),

    'client_secret' => env('TRAKT_CLIENT_SECRET'),

    'headers' => [
        'Content-type' => 'application/json',
        'trakt-api-version' => env('TRAKT_API_VERSION', '2'),
        'trakt-api-key' => env('TRAKT_CLIENT_ID'),
    ],

    'redirect_url' => env('TRAKT_REDIRECT_URL'),
];
