<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktMovie;

/**
 * TraktMovie test suite
 */

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktMovie = new TraktMovie($this->mockClient);
    
    // Common test data
    $this->traktId = 'the-dark-knight';
    $this->page = 1;
    $this->limit = 10;
});

test('it can be instantiated with client interface', function () {
    expect($this->traktMovie)->toBeInstanceOf(TraktMovie::class);
});

test('trending method calls client with correct parameters', function (bool $extended, ?string $level, ?string $filters) {
    // Setup expected parameters
    $paginationParams = ['page' => 1, 'limit' => 10];
    $extendedParams = $extended ? ['extended' => $level ?? 'full'] : [];
    $filterParams = $filters ? ['filters' => $filters] : [];
    $params = array_merge($paginationParams, $extendedParams, $filterParams);
    
    // Mock the parameter building methods
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with($extended, $level)
        ->andReturn($extendedParams);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->with(array_merge($paginationParams, $extendedParams), $filters)
        ->andReturn($params);
    
    // Mock the get request
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('movies/trending', $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    // Call the method
    $result = $this->traktMovie->trending($this->page, $this->limit, $extended, $level, $filters);
    
    expect($result)->toBeArray();
})->with([
    [false, null, null],
    [true, 'full', null],
    [true, 'full', 'years=2020-2023']
]);

test('popular method calls client with correct parameters', function () {
    $paginationParams = ['page' => 1, 'limit' => 10];
    $extendedParams = ['extended' => 'full'];
    $params = array_merge($paginationParams, $extendedParams);
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($extendedParams);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->andReturn($params);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('movies/popular', $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->popular($this->page, $this->limit, true, 'full');
    
    expect($result)->toBeArray();
});

test('favorited method calls client with correct endpoint and period', function (string $period) {
    $paginationParams = ['page' => 1, 'limit' => 10];
    $extendedParams = [];
    $params = $paginationParams;
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($extendedParams);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->andReturn($params);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/favorited/{$period}", $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->favorited($this->page, $this->limit, $period);
    
    expect($result)->toBeArray();
})->with([
    'weekly',
    'monthly',
    'yearly',
    'all'
]);

test('played method calls client with correct endpoint and period', function () {
    $period = 'monthly';
    $paginationParams = ['page' => 1, 'limit' => 10];
    $params = $paginationParams;
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn([]);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->andReturn($params);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/played/{$period}", $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->played($this->page, $this->limit, $period);
    
    expect($result)->toBeArray();
});

test('watched method calls client with correct endpoint and period', function () {
    $period = 'yearly';
    $paginationParams = ['page' => 1, 'limit' => 10];
    $params = $paginationParams;
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn([]);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->andReturn($params);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/watched/{$period}", $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->watched($this->page, $this->limit, $period);
    
    expect($result)->toBeArray();
});

test('collected method calls client with correct endpoint and period', function () {
    $period = 'all';
    $paginationParams = ['page' => 1, 'limit' => 10];
    $params = $paginationParams;
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn([]);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->andReturn($params);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/collected/{$period}", $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->collected($this->page, $this->limit, $period);
    
    expect($result)->toBeArray();
});

test('anticipated method calls client with correct parameters', function () {
    $paginationParams = ['page' => 1, 'limit' => 10];
    $extendedParams = ['extended' => 'full'];
    $params = array_merge($paginationParams, $extendedParams);
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($extendedParams);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->andReturn($params);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('movies/anticipated', $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->anticipated($this->page, $this->limit, true, 'full');
    
    expect($result)->toBeArray();
});

test('boxOffice method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('movies/boxoffice', [])
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->boxOffice();
    
    expect($result)->toBeArray();
});

test('get method calls client with correct parameters', function () {
    $extendedParams = ['extended' => 'full'];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(true, 'full')
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/{$this->traktId}", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->get($this->traktId, true, 'full');
    
    expect($result)->toBeArray();
});

test('aliases method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/{$this->traktId}/aliases", [])
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->aliases($this->traktId);
    
    expect($result)->toBeArray();
});

test('releases method calls client with correct endpoint and country', function (string $country) {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/{$this->traktId}/releases/{$country}", [])
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->releases($this->traktId, $country);
    
    expect($result)->toBeArray();
})->with([
    'us',
    'uk',
    'ca'
]);

test('people method calls client with correct endpoint', function () {
    $extendedParams = ['extended' => 'full'];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/{$this->traktId}/people", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->people($this->traktId, true, 'full');
    
    expect($result)->toBeArray();
});

test('ratings method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/{$this->traktId}/ratings", [])
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->ratings($this->traktId);
    
    expect($result)->toBeArray();
});

test('related method calls client with correct parameters', function () {
    $paginationParams = ['page' => 1, 'limit' => 10];
    $extendedParams = ['extended' => 'full'];
    $params = array_merge($paginationParams, $extendedParams);
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/{$this->traktId}/related", $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->related($this->traktId, $this->page, $this->limit, true, 'full');
    
    expect($result)->toBeArray();
});

test('stats method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/{$this->traktId}/stats", [])
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->stats($this->traktId);
    
    expect($result)->toBeArray();
});

test('watching method calls client with correct endpoint', function () {
    $extendedParams = ['extended' => 'full'];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/{$this->traktId}/watching", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktMovie->watching($this->traktId, true, 'full');
    
    expect($result)->toBeArray();
});

test('trending method returns properly formatted response data', function () {
    $expectedData = [
        [
            'watchers' => 100,
            'movie' => [
                'title' => 'The Dark Knight',
                'year' => 2008,
                'ids' => [
                    'trakt' => 4,
                    'slug' => 'the-dark-knight-2008',
                    'imdb' => 'tt0468569',
                    'tmdb' => 155
                ]
            ]
        ]
    ];
    
    $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
    $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
    $this->mockClient->shouldReceive('addFiltersToParams')->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('movies/trending', [])
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktMovie->trending();
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('watchers')
        ->toHaveKey('movie');
        
    expect($result[0]['movie'])
        ->toHaveKey('title')
        ->toHaveKey('year')
        ->toHaveKey('ids');
});

test('get method returns properly formatted movie data', function () {
    $expectedData = [
        'title' => 'The Dark Knight',
        'year' => 2008,
        'ids' => [
            'trakt' => 4,
            'slug' => 'the-dark-knight-2008',
            'imdb' => 'tt0468569',
            'tmdb' => 155
        ],
        'tagline' => 'Why So Serious?',
        'overview' => 'Batman raises the stakes in his war on crime.',
        'released' => '2008-07-18',
        'runtime' => 152,
        'country' => 'us',
        'trailer' => 'https://youtube.com/watch?v=EXeTwQWrcwY',
        'homepage' => 'https://www.warnerbros.com/movies/dark-knight',
        'rating' => 9.03,
        'votes' => 25783,
        'language' => 'en'
    ];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("movies/{$this->traktId}", [])
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktMovie->get($this->traktId);
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result)
        ->toHaveKey('title')
        ->toHaveKey('year')
        ->toHaveKey('ids');
});

test('movie methods handle error responses', function (string $method, array $args) {
    // Setup mocks based on method
    if (in_array($method, ['trending', 'popular', 'favorited', 'played', 'watched', 'collected', 'anticipated'])) {
        $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
        $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
        $this->mockClient->shouldReceive('addFiltersToParams')->andReturn([]);
    } elseif (in_array($method, ['get', 'people', 'related', 'watching'])) {
        $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
        
        if ($method === 'related') {
            $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
        }
    }
    
    $this->mockClient->shouldReceive('get')
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    // Call the method with appropriate arguments
    $methodCall = fn() => $this->traktMovie->{$method}(...$args);
    
    expect($methodCall)->toThrow(Exception::class, 'API error');
})->with([
    ['trending', [1, 10, false, null, null]],
    ['popular', [1, 10, false, null, null]],
    ['favorited', [1, 10, 'weekly', false, null, null]],
    ['played', [1, 10, 'weekly', false, null, null]],
    ['watched', [1, 10, 'weekly', false, null, null]],
    ['collected', [1, 10, 'weekly', false, null, null]],
    ['anticipated', [1, 10, false, null, null]],
    ['boxOffice', []],
    ['get', ['the-dark-knight', false, null]],
    ['aliases', ['the-dark-knight']],
    ['releases', ['the-dark-knight', 'us']],
    ['people', ['the-dark-knight', false, null]],
    ['ratings', ['the-dark-knight']],
    ['related', ['the-dark-knight', 1, 10, false, null]],
    ['stats', ['the-dark-knight']],
    ['watching', ['the-dark-knight', false, null]]
]);
