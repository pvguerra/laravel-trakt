<?php

return [
    'api_url' => env('TRAKT_API_URL', 'https://api.trakt.tv/'),

    'client_id' => env('TRAKT_CLIENT_ID'),

    'client_secret' => env('TRAKT_CLIENT_SECRET'),

    'headers' => [
        'Content-Type' => 'application/json',
        'User-Agent' => env('APP_NAME') . '/' . env('APP_VERSION'),
        'trakt-api-version' => env('TRAKT_API_VERSION', '2'),
        'trakt-api-key' => env('TRAKT_CLIENT_ID'),
    ],

    'redirect_url' => env('TRAKT_REDIRECT_URL'),

    'staging_api_url' => env('STAGING_TRAKT_API_URL', 'https://api-staging.trakt.tv/'),

    'staging_client_id' => env('STAGING_TRAKT_CLIENT_ID'),

    'staging_client_secret' => env('STAGING_TRAKT_CLIENT_SECRET'),

    'staging_headers' => [
        'Content-Type' => 'application/json',
        'User-Agent' => env('APP_NAME') . '/' . env('APP_VERSION'),
        'trakt-api-version' => env('TRAKT_API_VERSION', '2'),
        'trakt-api-key' => env('STAGING_TRAKT_CLIENT_ID'),
    ],
];
