
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Integrate Laravel with Trakt API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pvguerra/laravel-trakt.svg?style=flat-square)](https://packagist.org/packages/pvguerra/laravel-trakt)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/pvguerra/laravel-trakt/run-tests?label=tests)](https://github.com/pvguerra/laravel-trakt/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/pvguerra/laravel-trakt/Check%20&%20fix%20styling?label=code%20style)](https://github.com/pvguerra/laravel-trakt/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pvguerra/laravel-trakt.svg?style=flat-square)](https://packagist.org/packages/pvguerra/laravel-trakt)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-trakt.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-trakt)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

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

```php
$laravelTrakt = new Pvguerra\LaravelTrakt();
echo $laravelTrakt->echoPhrase('Hello, Pvguerra!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Paulo Guerra](https://github.com/pvguerra)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
