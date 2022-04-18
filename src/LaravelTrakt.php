<?php

namespace Pvguerra\LaravelTrakt;

class LaravelTrakt
{
    protected string $apiUrl;
    protected array $headers;

    public function __construct(protected ?string $apiToken = null)
    {
        $this->apiUrl = config('trakt.api_url');
        $this->headers = config('trakt.headers');
    }
}
