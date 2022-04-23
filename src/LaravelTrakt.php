<?php

namespace Pvguerra\LaravelTrakt;

class LaravelTrakt
{
    protected string $apiUrl;
    protected string $clientId;
    protected string $clientSecret;
    protected array $headers;
    protected string $redirectUrl;

    public function __construct(protected ?string $apiToken = null)
    {
        $this->apiUrl = config('trakt.api_url');
        $this->clientId = config('trakt.client_id');
        $this->clientSecret = config('trakt.client_secret');
        $this->headers = config('trakt.headers');
        $this->redirectUrl = config('trakt.redirect_url');
    }
}
