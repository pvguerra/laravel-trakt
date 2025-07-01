# Laravel Trakt

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pvguerra/laravel-trakt.svg?style=flat-square)](https://packagist.org/packages/pvguerra/laravel-trakt)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/pvguerra/laravel-trakt/ci.yml?branch=main&label=tests&style=flat-square)](https://github.com/pvguerra/laravel-trakt/actions?query=workflow%3Aci+branch%3Amain)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%204-brightgreen.svg?style=flat-square)](https://github.com/pvguerra/laravel-trakt/actions?query=workflow%3Aci+branch%3Amain)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![PHP Version](https://img.shields.io/packagist/php-v/pvguerra/laravel-trakt.svg?style=flat-square)](https://packagist.org/packages/pvguerra/laravel-trakt)
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

#### Using with Laravel Socialite

```php
use Laravel\Socialite\Facades\Socialite;

public function redirect()
{
    return Socialite::driver('trakt')->redirect();
}

// Receiving the callback from the provider after authentication.
public function callback()
{
    $socialiteUser = Socialite::driver('trakt')->user();
    
    // Store the token in your database
    $user = auth()->user();
    $user->trakt_token = $socialiteUser->token;
    $user->trakt_id = $socialiteUser->id;
    $user->save();
    
    return redirect()->route('dashboard');
}
```

#### Using the token

Once you have an access token, you can set it on the client:

```php
use Pvguerra\LaravelTrakt\Facades\Trakt;

// Using the facade
Trakt::setToken('your-access-token');

// Now you can make authenticated requests
$history = Trakt::sync()->history();

// Or using dependency injection
use Pvguerra\LaravelTrakt\TraktUser;

$user = auth()->user();
$traktUser = new TraktUser($user->trakt_token);
return $traktUser->collection($user->trakt_id, 'movies');
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

## Quality Assurance

### Testing

This package uses [Pest](https://pestphp.com/) for testing. Run the tests with:

```bash
composer test
```

### Static Analysis

This package uses [PHPStan](https://phpstan.org/) level 4 for static code analysis. Run the analysis with:

```bash
composer analyse
```

### CI/CD

This package uses GitHub Actions to run tests and static analysis on each pull request and push to the main branch. The CI pipeline ensures that:

1. All tests pass
2. PHPStan analysis passes with no errors
3. Branch protection rules prevent merging to main if tests or analysis fail

## Requirements

- PHP 8.1 or higher
- Laravel 9.0 or higher

## Compatibility

| Laravel | PHP       |
|---------|----------|
| 9.x     | 8.1, 8.2 |
| 10.x    | 8.1, 8.2, 8.3 |

## Documentation

Full documentation will be available soon.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

Pull requests are welcome!

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Paulo Guerra](https://github.com/pvguerra)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
