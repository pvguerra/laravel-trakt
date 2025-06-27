<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktShow;

/**
 * TraktShow test suite
 */

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktShow = new TraktShow($this->mockClient);
    
    // Common test data
    $this->traktId = 'breaking-bad';
    $this->page = 1;
    $this->limit = 10;
});

test('it can be instantiated with client interface', function () {
    expect($this->traktShow)->toBeInstanceOf(TraktShow::class);
});

test('trending method calls client with correct parameters', function (bool $extended, ?string $level, ?string $filters) {
    $paginationParams = ['page' => $this->page, 'limit' => $this->limit];
    $extendedParams = $extended ? ['extended' => $level ?? 'full'] : [];
    $mergedParams = array_merge($paginationParams, $extendedParams);
    $finalParams = $filters ? array_merge($mergedParams, ['filters' => $filters]) : $mergedParams;
    
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
        ->with($mergedParams, $filters)
        ->andReturn($finalParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/trending", $finalParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->trending($this->page, $this->limit, $extended, $level, $filters);
    
    expect($result)->toBeArray();
})->with([
    [false, null, null],
    [true, 'full', null],
    [true, 'full', 'years=2020-2023']
]);

test('popular method calls client with correct parameters', function () {
    $paginationParams = ['page' => $this->page, 'limit' => $this->limit];
    $extendedParams = ['extended' => 'full'];
    $mergedParams = array_merge($paginationParams, $extendedParams);
    $finalParams = array_merge($mergedParams, ['filters' => 'years=2020-2023']);
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
        
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(true, 'full')
        ->andReturn($extendedParams);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->with($mergedParams, 'years=2020-2023')
        ->andReturn($finalParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/popular", $finalParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->popular($this->page, $this->limit, true, 'full', 'years=2020-2023');
    
    expect($result)->toBeArray();
});

test('favorited method calls client with correct endpoint and period', function (string $period) {
    $paginationParams = ['page' => $this->page, 'limit' => $this->limit];
    $extendedParams = [];
    $mergedParams = array_merge($paginationParams, $extendedParams);
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
        
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(false, null)
        ->andReturn($extendedParams);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->with($mergedParams, null)
        ->andReturn($mergedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/favorited/{$period}", $mergedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->favorited($this->page, $this->limit, $period);
    
    expect($result)->toBeArray();
})->with([
    'weekly',
    'monthly',
    'yearly',
    'all'
]);

test('played method calls client with correct endpoint and period', function () {
    $paginationParams = ['page' => $this->page, 'limit' => $this->limit];
    $extendedParams = [];
    $mergedParams = array_merge($paginationParams, $extendedParams);
    $period = 'weekly';
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
        
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(false, null)
        ->andReturn($extendedParams);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->with($mergedParams, null)
        ->andReturn($mergedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/played/{$period}", $mergedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->played($this->page, $this->limit, $period);
    
    expect($result)->toBeArray();
});

test('watched method calls client with correct endpoint and period', function () {
    $paginationParams = ['page' => $this->page, 'limit' => $this->limit];
    $extendedParams = [];
    $mergedParams = array_merge($paginationParams, $extendedParams);
    $period = 'weekly';
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
        
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(false, null)
        ->andReturn($extendedParams);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->with($mergedParams, null)
        ->andReturn($mergedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/watched/{$period}", $mergedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->watched($this->page, $this->limit, $period);
    
    expect($result)->toBeArray();
});

test('collected method calls client with correct endpoint and period', function () {
    $paginationParams = ['page' => $this->page, 'limit' => $this->limit];
    $extendedParams = [];
    $mergedParams = array_merge($paginationParams, $extendedParams);
    $period = 'weekly';
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
        
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(false, null)
        ->andReturn($extendedParams);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->with($mergedParams, null)
        ->andReturn($mergedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/collected/{$period}", $mergedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->collected($this->page, $this->limit, $period);
    
    expect($result)->toBeArray();
});

test('anticipated method calls client with correct parameters', function () {
    $paginationParams = ['page' => $this->page, 'limit' => $this->limit];
    $extendedParams = ['extended' => 'full'];
    $mergedParams = array_merge($paginationParams, $extendedParams);
    $finalParams = array_merge($mergedParams, ['filters' => 'years=2020-2023']);
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
        
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(true, 'full')
        ->andReturn($extendedParams);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->with($mergedParams, 'years=2020-2023')
        ->andReturn($finalParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/anticipated", $finalParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->anticipated($this->page, $this->limit, true, 'full', 'years=2020-2023');
    
    expect($result)->toBeArray();
});

test('get method calls client with correct parameters', function (bool $extended, ?string $level) {
    $extendedParams = $extended ? ['extended' => $level ?? 'full'] : [];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with($extended, $level)
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->get($this->traktId, $extended, $level);
    
    expect($result)->toBeArray();
})->with([
    [false, null],
    [true, 'full'],
    [true, 'metadata']
]);

test('aliases method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/aliases", [])
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->aliases($this->traktId);
    
    expect($result)->toBeArray();
});

test('certifications method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/certifications", [])
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->certifications($this->traktId);
    
    expect($result)->toBeArray();
});

test('translations method calls client with correct endpoint and language', function (string $language) {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/translations/{$language}", [])
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->translations($this->traktId, $language);
    
    expect($result)->toBeArray();
})->with([
    'pt',
    'en',
    'es'
]);

test('people method calls client with correct endpoint', function () {
    $extendedParams = ['extended' => 'full'];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(true, 'full')
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/people", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->people($this->traktId, true, 'full');
    
    expect($result)->toBeArray();
});

test('ratings method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/ratings", [])
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->ratings($this->traktId);
    
    expect($result)->toBeArray();
});

test('related method calls client with correct parameters', function () {
    $paginationParams = ['page' => $this->page, 'limit' => $this->limit];
    $extendedParams = ['extended' => 'full'];
    $mergedParams = array_merge($paginationParams, $extendedParams);
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
        
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(true, 'full')
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/related", $mergedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->related($this->traktId, $this->page, $this->limit, true, 'full');
    
    expect($result)->toBeArray();
});

test('stats method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/stats", [])
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->stats($this->traktId);
    
    expect($result)->toBeArray();
});

test('watching method calls client with correct endpoint', function () {
    $extendedParams = ['extended' => 'full'];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(true, 'full')
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/watching", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->watching($this->traktId, true, 'full');
    
    expect($result)->toBeArray();
});

test('nextEpisode method calls client with correct endpoint', function () {
    $extendedParams = ['extended' => 'full'];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(true, 'full')
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/next_episode", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->nextEpisode($this->traktId, true, 'full');
    
    expect($result)->toBeArray();
});

test('lastEpisode method calls client with correct endpoint', function () {
    $extendedParams = ['extended' => 'full'];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(true, 'full')
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/last_episode", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->lastEpisode($this->traktId, true, 'full');
    
    expect($result)->toBeArray();
});

test('videos method calls client with correct endpoint', function () {
    $extendedParams = ['extended' => 'full'];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with(true, 'full')
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/videos", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktShow->videos($this->traktId, true, 'full');
    
    expect($result)->toBeArray();
});

test('trending method returns properly formatted response data', function () {
    $expectedData = [
        [
            'watchers' => 352,
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
    $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
    $this->mockClient->shouldReceive('addFiltersToParams')->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('shows/trending', [])
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktShow->trending();
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('watchers')
        ->toHaveKey('show');
        
    expect($result[0]['show'])
        ->toHaveKey('title')
        ->toHaveKey('year')
        ->toHaveKey('ids');
});

test('get method returns properly formatted show data', function () {
    $expectedData = [
        'title' => 'Breaking Bad',
        'year' => 2008,
        'ids' => [
            'trakt' => 1388,
            'slug' => 'breaking-bad',
            'tvdb' => 81189,
            'imdb' => 'tt0903747',
            'tmdb' => 1396
        ],
        'overview' => 'A high school chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine in order to secure his family\'s future.',
        'first_aired' => '2008-01-20T07:00:00.000Z',
        'airs' => [
            'day' => 'Sunday',
            'time' => '22:00',
            'timezone' => 'America/New_York'
        ],
        'runtime' => 45,
        'certification' => 'TV-MA',
        'network' => 'AMC',
        'country' => 'us',
        'updated_at' => '2023-01-01T00:00:00.000Z',
        'status' => 'ended',
        'genres' => ['drama', 'crime', 'thriller']
    ];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}", [])
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktShow->get($this->traktId);
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result)
        ->toHaveKey('title')
        ->toHaveKey('year')
        ->toHaveKey('ids')
        ->toHaveKey('overview')
        ->toHaveKey('first_aired')
        ->toHaveKey('airs')
        ->toHaveKey('genres');
});

test('show methods handle empty response correctly', function (string $method, array $args) {
    // Setup mocks based on method type
    if (in_array($method, ['trending', 'popular', 'favorited', 'played', 'watched', 'collected', 'anticipated'])) {
        $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
        $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
        $this->mockClient->shouldReceive('addFiltersToParams')->andReturn([]);
    } elseif (in_array($method, ['get', 'people', 'related', 'watching', 'nextEpisode', 'lastEpisode', 'videos'])) {
        $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
        if ($method === 'related') {
            $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
        }
    }
    
    $this->mockClient->shouldReceive('get')
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    // Call the method with appropriate arguments
    $methodCall = fn() => $this->traktShow->{$method}(...$args);
    
    expect($methodCall())->toBeArray()->toBeEmpty();
})->with([
    ['trending', [1, 10, false, null, null]],
    ['popular', [1, 10, false, null, null]],
    ['favorited', [1, 10, 'weekly', false, null, null]],
    ['played', [1, 10, 'weekly', false, null, null]],
    ['watched', [1, 10, 'weekly', false, null, null]],
    ['collected', [1, 10, 'weekly', false, null, null]],
    ['anticipated', [1, 10, false, null, null]],
    ['get', ['breaking-bad', false, null]],
    ['aliases', ['breaking-bad']],
    ['certifications', ['breaking-bad']],
    ['translations', ['breaking-bad', 'en']],
    ['people', ['breaking-bad', false, null]],
    ['ratings', ['breaking-bad']],
    ['related', ['breaking-bad', 1, 10, false, null]],
    ['stats', ['breaking-bad']],
    ['watching', ['breaking-bad', false, null]],
    ['nextEpisode', ['breaking-bad', false, null]],
    ['lastEpisode', ['breaking-bad', false, null]],
    ['videos', ['breaking-bad', false, null]]
]);

test('show methods handle error responses', function (string $method, array $args) {
    // Setup mocks based on method type
    if (in_array($method, ['trending', 'popular', 'favorited', 'played', 'watched', 'collected', 'anticipated'])) {
        $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
        $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
        $this->mockClient->shouldReceive('addFiltersToParams')->andReturn([]);
    } elseif (in_array($method, ['get', 'people', 'related', 'watching', 'nextEpisode', 'lastEpisode', 'videos'])) {
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
    $methodCall = fn() => $this->traktShow->{$method}(...$args);
    
    expect($methodCall)->toThrow(Exception::class, 'API error');
})->with([
    ['trending', [1, 10, false, null, null]],
    ['popular', [1, 10, false, null, null]],
    ['favorited', [1, 10, 'weekly', false, null, null]],
    ['played', [1, 10, 'weekly', false, null, null]],
    ['watched', [1, 10, 'weekly', false, null, null]],
    ['collected', [1, 10, 'weekly', false, null, null]],
    ['anticipated', [1, 10, false, null, null]],
    ['get', ['breaking-bad', false, null]],
    ['aliases', ['breaking-bad']],
    ['certifications', ['breaking-bad']],
    ['translations', ['breaking-bad', 'en']],
    ['people', ['breaking-bad', false, null]],
    ['ratings', ['breaking-bad']],
    ['related', ['breaking-bad', 1, 10, false, null]],
    ['stats', ['breaking-bad']],
    ['watching', ['breaking-bad', false, null]],
    ['nextEpisode', ['breaking-bad', false, null]],
    ['lastEpisode', ['breaking-bad', false, null]],
    ['videos', ['breaking-bad', false, null]]
]);
