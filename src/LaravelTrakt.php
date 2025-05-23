<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class LaravelTrakt
{
    protected string $apiUrl;
    protected string $clientId;
    protected string $clientSecret;
    protected array $headers;
    protected string $redirectUrl;
    protected PendingRequest $client;

    public function __construct(protected ?string $apiToken = null)
    {
        $this->apiUrl = config('trakt.api_url');
        $this->clientId = config('trakt.client_id');
        $this->clientSecret = config('trakt.client_secret');
        $this->headers = config('trakt.headers');
        $this->redirectUrl = config('trakt.redirect_url');

        $this->client = Http::withHeaders($this->headers)
            ->baseUrl($this->apiUrl)
            ->connectTimeout(3)
            ->retry(3, 100, function ($exception) {
                return $exception instanceof ConnectionException;
            })
            ->timeout(30);
    }
}
