<?php

namespace Pvguerra\LaravelTrakt;

class LaravelTrakt
{
    protected string $apiUrl;
    protected array $headers;

    public function __construct(protected ?string $apiToken = null)
    {
        $this->apiUrl = config('trakt.staging_api_url');
        $this->headers = config('trakt.staging_headers');
    }
}
