<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class Client implements ClientInterface
{
    private string $baseUrl;
    private string $clientId;
    private string $clientSecret;
    private array $headers;
    private string $redirectUrl;
    private string $apiVersion = '2';
    private PendingRequest $httpClient;

    public function __construct()
    {
        $this->baseUrl = config('trakt.api_url', 'https://api.trakt.tv');
        $this->clientId = config('trakt.client_id');
        $this->clientSecret = config('trakt.client_secret');
        $this->headers = config('trakt.headers', [
            'Content-Type' => 'application/json',
            'trakt-api-version' => $this->apiVersion,
            'trakt-api-key' => $this->clientId,
        ]);
        $this->redirectUrl = config('trakt.redirect_url');

        $this->httpClient = Http::withHeaders($this->headers)
            ->baseUrl($this->baseUrl)
            ->connectTimeout(3)
            ->retry(3, 100, function ($exception) {
                return $exception instanceof ConnectionException;
            })
            ->timeout(30);
    }

    public function get(string $endpoint, array $params = []): Response
    {
        return $this->httpClient->get($endpoint, $params);
    }

    public function post(string $endpoint, array $data = []): Response
    {
        return $this->httpClient->post($endpoint, $data);
    }

    public function put(string $endpoint, array $data = []): Response
    {
        return $this->httpClient->put($endpoint, $data);
    }

    public function delete(string $endpoint, array $params = []): Response
    {
        return $this->httpClient->delete($endpoint, $params);
    }

    public function buildQueryString(array $params): string
    {
        if (empty($params)) {
            return '';
        }
        
        return '?' . http_build_query($params);
    }

    public function buildPaginationParams(int $page = 1, int $limit = 10): array
    {
        return [
            'page' => $page,
            'limit' => $limit
        ];
    }

    public function buildExtendedParams(bool $extended, ?string $level): array
    {
        $params = [];
        
        if ($extended && $level) {
            $params['extended'] = $level;
        }
        
        return $params;
    }
    
    public function addFiltersToParams(array $params, ?string $filters): array
    {
        if ($filters) {
            parse_str($filters, $filterParams);
            $params = array_merge($params, $filterParams);
        }
        
        return $params;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
