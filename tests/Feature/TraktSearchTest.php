<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktSearch;

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktSearch = new TraktSearch($this->mockClient);
});

test('it can be instantiated with client interface', function () {
    expect($this->traktSearch)->toBeInstanceOf(TraktSearch::class);
});

test('query method calls client with correct parameters', function (int $page, int $limit, string $type, string $query) {
    $paginationParams = ['page' => $page, 'limit' => $limit];
    $expectedParams = array_merge($paginationParams, ['query' => $query]);
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($page, $limit)
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("search/{$type}", $expectedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktSearch->query($page, $limit, $type, $query);
    
    expect($result)->toBeArray();
})->with([
    [1, 10, 'movie', 'matrix'],
    [2, 20, 'show', 'breaking bad'],
    [3, 30, 'person', 'bryan cranston'],
    [1, 10, 'movie,show', 'star wars']
]);

test('query method returns properly formatted movie search results', function () {
    $expectedData = [
        [
            'type' => 'movie',
            'score' => 42.56789,
            'movie' => [
                'title' => 'The Matrix',
                'year' => 1999,
                'ids' => [
                    'trakt' => 481,
                    'slug' => 'the-matrix-1999',
                    'imdb' => 'tt0133093',
                    'tmdb' => 603
                ]
            ]
        ]
    ];
    
    $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('search/movie', ['query' => 'matrix'])
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktSearch->query(1, 10, 'movie', 'matrix');
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('type')
        ->toHaveKey('score')
        ->toHaveKey('movie');
        
    expect($result[0]['movie'])
        ->toHaveKey('title')
        ->toHaveKey('year')
        ->toHaveKey('ids');
});

test('query method returns properly formatted show search results', function () {
    $expectedData = [
        [
            'type' => 'show',
            'score' => 42.56789,
            'show' => [
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
        ]
    ];
    
    $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('search/show', ['query' => 'breaking bad'])
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktSearch->query(1, 10, 'show', 'breaking bad');
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('type')
        ->toHaveKey('score')
        ->toHaveKey('show');
        
    expect($result[0]['show'])
        ->toHaveKey('title')
        ->toHaveKey('year')
        ->toHaveKey('ids');
});

test('query method handles empty response correctly', function () {
    $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktSearch->query();
    
    expect($result)
        ->toBeArray()
        ->toBeEmpty();
});

test('query method handles error responses', function () {
    $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    expect(fn() => $this->traktSearch->query())
        ->toThrow(Exception::class, 'API error');
});
