<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktList;

/**
 * TraktList test suite
 */

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktList = new TraktList($this->mockClient);
    
    // Common test data
    $this->traktId = 123456;
    $this->page = 1;
    $this->limit = 10;
});

test('it can be instantiated with client interface', function () {
    expect($this->traktList)->toBeInstanceOf(TraktList::class);
});

test('trending method calls client with correct parameters', function () {
    $paginationParams = ['page' => 1, 'limit' => 10];
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('lists/trending', $paginationParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktList->trending($this->page, $this->limit);
    
    expect($result)->toBeArray();
});

test('popular method calls client with correct parameters', function () {
    $paginationParams = ['page' => 1, 'limit' => 10];
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('lists/popular', $paginationParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktList->popular($this->page, $this->limit);
    
    expect($result)->toBeArray();
});

test('get method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("lists/{$this->traktId}")
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktList->get($this->traktId);
    
    expect($result)->toBeArray();
});

test('items method calls client with correct parameters', function (string $type, bool $extended, ?string $level) {
    $paginationParams = ['page' => 1, 'limit' => 10];
    $extendedParams = $extended ? ['extended' => $level ?? 'full'] : [];
    $params = array_merge($paginationParams, $extendedParams);
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with($extended, $level)
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("lists/{$this->traktId}/items/{$type}", $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktList->items($this->traktId, $type, $this->page, $this->limit, $extended, $level);
    
    expect($result)->toBeArray();
})->with([
    ['movies', false, null],
    ['shows', true, 'full'],
    ['episodes', true, 'metadata'],
    ['people', false, null],
    ['movies,shows', true, 'full']
]);

test('trending method returns properly formatted response data', function () {
    $expectedData = [
        [
            'like_count' => 10,
            'comment_count' => 5,
            'list' => [
                'name' => 'Best Movies of 2023',
                'description' => 'My favorite movies from 2023',
                'privacy' => 'public',
                'user' => [
                    'username' => 'johndoe',
                    'name' => 'John Doe'
                ]
            ]
        ]
    ];
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('lists/trending', [])
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktList->trending();
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('like_count')
        ->toHaveKey('comment_count')
        ->toHaveKey('list');
        
    expect($result[0]['list'])
        ->toHaveKey('name')
        ->toHaveKey('description')
        ->toHaveKey('privacy')
        ->toHaveKey('user');
});

test('get method returns properly formatted list data', function () {
    $expectedData = [
        'name' => 'Best Movies of 2023',
        'description' => 'My favorite movies from 2023',
        'privacy' => 'public',
        'display_numbers' => true,
        'allow_comments' => true,
        'sort_by' => 'rank',
        'sort_how' => 'asc',
        'created_at' => '2023-01-01T00:00:00.000Z',
        'updated_at' => '2023-12-31T00:00:00.000Z',
        'item_count' => 25,
        'comment_count' => 5,
        'likes' => 10,
        'ids' => [
            'trakt' => 123456,
            'slug' => 'best-movies-of-2023'
        ],
        'user' => [
            'username' => 'johndoe',
            'name' => 'John Doe'
        ]
    ];
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("lists/{$this->traktId}")
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktList->get($this->traktId);
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result)
        ->toHaveKey('name')
        ->toHaveKey('description')
        ->toHaveKey('privacy')
        ->toHaveKey('ids')
        ->toHaveKey('user');
});

test('items method returns properly formatted items data', function () {
    $expectedData = [
        [
            'rank' => 1,
            'id' => 12345,
            'type' => 'movie',
            'movie' => [
                'title' => 'Oppenheimer',
                'year' => 2023,
                'ids' => [
                    'trakt' => 12345,
                    'slug' => 'oppenheimer-2023',
                    'imdb' => 'tt15398776',
                    'tmdb' => 872585
                ]
            ]
        ],
        [
            'rank' => 2,
            'id' => 12346,
            'type' => 'movie',
            'movie' => [
                'title' => 'Barbie',
                'year' => 2023,
                'ids' => [
                    'trakt' => 12346,
                    'slug' => 'barbie-2023',
                    'imdb' => 'tt1517268',
                    'tmdb' => 346698
                ]
            ]
        ]
    ];
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->andReturn([]);
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("lists/{$this->traktId}/items/movies", [])
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktList->items($this->traktId, 'movies', $this->page, $this->limit);
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('rank')
        ->toHaveKey('id')
        ->toHaveKey('type')
        ->toHaveKey('movie');
});

test('list methods handle error responses', function (string $method, array $args) {
    // Setup mocks based on method
    if (in_array($method, ['trending', 'popular'])) {
        $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
    } elseif ($method === 'items') {
        $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
        $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
    }
    
    $this->mockClient->shouldReceive('get')
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    // Call the method with appropriate arguments
    $methodCall = fn() => $this->traktList->{$method}(...$args);
    
    expect($methodCall)->toThrow(Exception::class, 'API error');
})->with([
    ['trending', [1, 10]],
    ['popular', [1, 10]],
    ['get', [123456]],
    ['items', [123456, 'movies', 1, 10, false, null]]
]);
