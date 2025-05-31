<?php

namespace Pvguerra\LaravelTrakt\Contracts;

use Illuminate\Http\Client\Response;

interface ClientInterface
{
    public function get(string $endpoint, array $params = []): Response;
    
    public function post(string $endpoint, array $data = []): Response;
    
    public function put(string $endpoint, array $data = []): Response;
    
    public function delete(string $endpoint, array $params = []): Response;
    
    public function buildQueryString(array $params): string;
    
    public function buildPaginationParams(int $page = 1, int $limit = 10): array;

    public function buildExtendedParams(bool $extended, ?string $level): array;
    
    public function addFiltersToParams(array $params, ?string $filters): array;
    
    public function getHeaders(): array;
    
    public function getBaseUrl(): string;
}
