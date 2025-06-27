<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktRecommendation;

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktRecommendation = new TraktRecommendation($this->mockClient);
});

test('it can be instantiated with client interface', function () {
    expect($this->traktRecommendation)->toBeInstanceOf(TraktRecommendation::class);
});

test('getMovies method calls client with correct parameters', function (int $page, int $limit, bool $ignoreCollected) {
    $paginationParams = ['page' => $page, 'limit' => $limit];
    $expectedParams = array_merge($paginationParams, ['ignore_collected' => $ignoreCollected ? 'true' : 'false']);
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($page, $limit)
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('recommendations/movies', $expectedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktRecommendation->getMovies($page, $limit, $ignoreCollected);
    
    expect($result)->toBeArray();
})->with([
    [1, 10, false],
    [2, 20, true],
    [3, 100, false]
]);

test('hideMovie method calls client with correct endpoint', function () {
    $traktId = 'tt0944947';
    
    $this->mockClient->shouldReceive('delete')
        ->once()
        ->with("recommendations/movies/{$traktId}")
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktRecommendation->hideMovie($traktId);
    
    expect($result)->toBeArray();
});

test('getShows method calls client with correct parameters', function (int $page, int $limit, bool $ignoreCollected) {
    $paginationParams = ['page' => $page, 'limit' => $limit];
    $expectedParams = array_merge($paginationParams, ['ignore_collected' => $ignoreCollected ? 'true' : 'false']);
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($page, $limit)
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('recommendations/shows', $expectedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktRecommendation->getShows($page, $limit, $ignoreCollected);
    
    expect($result)->toBeArray();
})->with([
    [1, 10, false],
    [2, 20, true],
    [3, 100, false]
]);

test('hideShow method calls client with correct endpoint', function () {
    $traktId = 'tt0944947';
    
    $this->mockClient->shouldReceive('delete')
        ->once()
        ->with("recommendations/shows/{$traktId}")
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktRecommendation->hideShow($traktId);
    
    expect($result)->toBeArray();
});

test('getMovies method returns properly formatted response data', function () {
    $expectedData = [
        [
            'title' => 'The Godfather',
            'year' => 1972,
            'ids' => [
                'trakt' => 770,
                'slug' => 'the-godfather-1972',
                'imdb' => 'tt0068646',
                'tmdb' => 238
            ]
        ]
    ];
    
    $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktRecommendation->getMovies();
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('title')
        ->toHaveKey('year')
        ->toHaveKey('ids');
});

test('getShows method returns properly formatted response data', function () {
    $expectedData = [
        [
            'title' => 'Breaking Bad',
            'year' => 2008,
            'ids' => [
                'trakt' => 1388,
                'slug' => 'breaking-bad',
                'tvdb' => 81189,
                'imdb' => 'tt0903747',
                'tmdb' => 1396
            ]
        ]
    ];
    
    $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktRecommendation->getShows();
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('title')
        ->toHaveKey('year')
        ->toHaveKey('ids');
});

test('recommendation methods handle error responses', function (string $method, array $args) {
    if (in_array($method, ['getMovies', 'getShows'])) {
        $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
    }
    
    $this->mockClient->shouldReceive('get', 'delete')
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    $methodCall = fn() => $this->traktRecommendation->{$method}(...$args);
    
    expect($methodCall)->toThrow(Exception::class, 'API error');
})->with([
    ['getMovies', [1, 10, false]],
    ['hideMovie', ['tt0068646']],
    ['getShows', [1, 10, false]],
    ['hideShow', ['tt0903747']]
]);

test('recommendation methods handle empty response correctly', function (string $method, array $args) {
    if (in_array($method, ['getMovies', 'getShows'])) {
        $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
    }
    
    $this->mockClient->shouldReceive('get', 'delete')
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $methodCall = fn() => $this->traktRecommendation->{$method}(...$args);
    
    expect($methodCall())->toBeArray()->toBeEmpty();
})->with([
    ['getMovies', [1, 10, false]],
    ['hideMovie', ['tt0068646']],
    ['getShows', [1, 10, false]],
    ['hideShow', ['tt0903747']]
]);
