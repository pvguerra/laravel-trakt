# Laravel Trakt

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pvguerra/laravel-trakt.svg?style=flat-square)](https://packagist.org/packages/pvguerra/laravel-trakt)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/pvguerra/laravel-trakt/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/pvguerra/laravel-trakt/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/pvguerra/laravel-trakt/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/pvguerra/laravel-trakt/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pvguerra/laravel-trakt.svg?style=flat-square)](https://packagist.org/packages/pvguerra/laravel-trakt)

This package provides a convenient way to integrate the [Trakt.tv API](https://trakt.docs.apiary.io/) with your Laravel application.

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

This will publish the `trakt.php` config file to your `config` directory:

```php
// config/trakt.php

return [
    'api_url' => env('TRAKT_API_URL', 'https://api.trakt.tv'),
    'client_id' => env('TRAKT_CLIENT_ID'),
    'client_secret' => env('TRAKT_CLIENT_SECRET'),
    'redirect_url' => env('TRAKT_REDIRECT_URL'),
    'staging_api_url' => env('STAGING_TRAKT_API_URL', 'https://api-staging.trakt.tv'),
];
```

You should add your Trakt API credentials and redirect URI to your `.env` file:

```.env
TRAKT_CLIENT_ID=your-trakt-client-id
TRAKT_CLIENT_SECRET=your-trakt-client-secret
TRAKT_REDIRECT_URL=your-trakt-redirect-url
```

If you don't have a Trakt client ID, you'll need to [create a new API app](https://trakt.tv/oauth/applications/new).

## Usage

This package provides a fluent interface to interact with the Trakt API. You can either use the `Trakt` facade or dependency injection to access the client.

Most methods return a `Illuminate\Http\Client\Response` object. You can call `->json()` or `->object()` on the response to get the data.

Here is a list of available classes you can use:

- `TraktCalendar`
- `TraktCertification`
- `TraktCheckIn`
- `TraktCountry`
- `TraktEpisode`
- `TraktGenre`
- `TraktLanguage`
- `TraktList`
- `TraktMovie`
- `TraktNetwork`
- `TraktPerson`
- `TraktRecommendation`
- `TraktSearch`
- `TraktSeason`
- `TraktShow`
- `TraktSync`
- `TraktUser`

### Authentication

Some endpoints require authentication. This package does not handle the OAuth2 flow for you, but it's easy to integrate with [Laravel Socialite](https://laravel.com/docs/socialite) and the [Trakt Socialite Provider](https://socialiteproviders.com/Trakt/).

Once you have an access token, you can set it on the client:

```php
use Pvguerra\LaravelTrakt\Facades\Trakt;

Trakt::setToken('your-access-token');

// Now you can make authenticated requests
$history = Trakt::sync()->history();
```

### Examples

#### Movies

Get a single movie:
```php
use Pvguerra\LaravelTrakt\Facades\Trakt;

$movie = Trakt::movie()->get('the-batman-2022');
```

Get popular movies:
```php
use Pvguerra\LaravelTrakt\Facades\Trakt;

$popularMovies = Trakt::movie()->popular();
```

#### TV Shows

Get a single show:
```php
use Pvguerra\LaravelTrakt\Facades\Trakt;

$show = Trakt::show()->get('game-of-thrones');
```

Get trending shows:
```php
use Pvguerra\LaravelTrakt\Facades\Trakt;

$trendingShows = Trakt::show()->trending();
```

#### Search

Search for a movie, show, person, etc.
```php
use Pvguerra\LaravelTrakt\Facades\Trakt;

$results = Trakt::search()->query('batman', 'movie');
```

#### User

Get a user's profile (requires authentication):
```php
use Pvguerra\LaravelTrakt\Facades\Trakt;

Trakt::setToken('user-access-token');
$profile = Trakt::user()->profile('me');
```

Get a user's watched history (requires authentication):
```php
use Pvguerra\LaravelTrakt\Facades\Trakt;

Trakt::setToken('user-access-token');
$history = Trakt::user()->history('me', 'movies');
```

#### Calendar

Get all shows airing in the next 7 days:
```php
use Pvguerra\LaravelTrakt\Facades\Trakt;

$calendar = Trakt::calendar()->myShows();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING.md](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Paulo Guerra](https://github.com/pvguerra)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

public function redirect()
{
    return Socialite::driver('trakt')->redirect();
}

// Receiving the callback from the provider after authentication.
public function callback()
{
    $socialiteUser = Socialite::driver('trakt')->user();

    //...
}
```

Then with the authenticated user:

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
