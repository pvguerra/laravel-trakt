
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Integrate Laravel with Trakt API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pvguerra/laravel-trakt.svg?style=flat-square)](https://packagist.org/packages/pvguerra/laravel-trakt)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/pvguerra/laravel-trakt/run-tests?label=tests)](https://github.com/pvguerra/laravel-trakt/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/pvguerra/laravel-trakt/Check%20&%20fix%20styling?label=code%20style)](https://github.com/pvguerra/laravel-trakt/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pvguerra/laravel-trakt.svg?style=flat-square)](https://packagist.org/packages/pvguerra/laravel-trakt)

The whole package was developed following the official [Trakt API Documentation](https://trakt.docs.apiary.io/).

## Installation

You can install the package via composer:

```bash
composer require pvguerra/laravel-trakt
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="trakt-config"
```

This is the contents of the published config file:

```php
return [
    'api_url' => env('TRAKT_API_URL'),

    'client_id' => env('TRAKT_CLIENT_ID'),

    'client_secret' => env('TRAKT_CLIENT_SECRET'),

    'headers' => [
        'Content-type' => 'application/json',
        'trakt-api-version' => env('TRAKT_API_VERSION', '2'),
        'trakt-api-key' => env('TRAKT_CLIENT_ID'),
    ],

    'redirect_url' => env('TRAKT_REDIRECT_URL'),

    'staging_api_url' => env('STAGING_TRAKT_API_URL'),

    'staging_client_id' => env('STAGING_TRAKT_CLIENT_ID'),

    'staging_client_secret' => env('STAGING_TRAKT_CLIENT_SECRET'),

    'staging_headers' => [
        'Content-type' => 'application/json',
        'trakt-api-version' => env('TRAKT_API_VERSION', '2'),
        'trakt-api-key' => env('STAGING_TRAKT_CLIENT_ID'),
    ],
];
```

## Usage

If you don't have a Trakt client ID, you'll need to [create a new API app](https://trakt.tv/oauth/applications/new).
Then you'll get all you need to fill the environment variables for configuration.

### Movies

```php
use Pvguerra\LaravelTrakt\TraktMovie;

# Example: Get a Movie 
$traktMovie = new TraktMovie();

return $traktMovie->get('the-batman-2022');
```

### TV Shows

```php
use Pvguerra\LaravelTrakt\TraktShow;

$traktShow = new TraktShow();

return $traktShow->popular();
```

### Auth Required

Some endpoints are auth required, for these you'll need an API Token.
At this point I strongly recommend [Trakt Socialite Providers](https://socialiteproviders.com/Trakt/#trakt) since it extends
[Laravel Socialite](https://laravel.com/docs/9.x/socialite) and works flawlessly.

Example:

```php
use Pvguerra\LaravelTrakt\TraktUser;

$user = auth()->user();

$traktUser = new TraktUser($user->token);

return $traktUser->collection($user->trakt_id, 'movies');
```

## Documentation

Full documentation will be available soon.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

Pull requests are welcome!

## Credits

- [Paulo Guerra](https://github.com/pvguerra)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
