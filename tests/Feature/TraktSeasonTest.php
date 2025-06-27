<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktSeason;

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktSeason = new TraktSeason($this->mockClient);
    $this->traktId = 'breaking-bad';
    $this->seasonNumber = 1;
});

test('it can be instantiated with client interface', function () {
    expect($this->traktSeason)->toBeInstanceOf(TraktSeason::class);
});

test('all method calls client with correct parameters', function (bool $extended, ?string $level) {
    $extendedParams = $extended ? ['extended' => $level ?: 'full'] : [];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with($extended, $level)
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktSeason->all($this->traktId, $extended, $level);
    
    expect($result)->toBeArray();
})->with([
    [false, null],
    [true, 'full'],
    [true, 'metadata']
]);

test('info method calls client with correct parameters', function (bool $extended, ?string $level) {
    $extendedParams = $extended ? ['extended' => $level ?: 'full'] : [];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with($extended, $level)
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/info", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktSeason->info($this->traktId, $extended, $level);
    
    expect($result)->toBeArray();
})->with([
    [false, null],
    [true, 'full'],
    [true, 'metadata']
]);

test('episodes method calls client with correct parameters', function (bool $extended, ?string $level) {
    $extendedParams = $extended ? ['extended' => $level ?: 'full'] : [];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with($extended, $level)
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/{$this->seasonNumber}", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktSeason->episodes($this->traktId, $this->seasonNumber, $extended, $level);
    
    expect($result)->toBeArray();
})->with([
    [false, null],
    [true, 'full'],
    [true, 'metadata']
]);

test('people method calls client with correct parameters', function (bool $extended, ?string $level) {
    $extendedParams = $extended ? ['extended' => $level ?: 'full'] : [];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with($extended, $level)
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/{$this->seasonNumber}/people", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktSeason->people($this->traktId, $this->seasonNumber, $extended, $level);
    
    expect($result)->toBeArray();
})->with([
    [false, null],
    [true, 'full'],
    [true, 'metadata']
]);

test('ratings method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/{$this->seasonNumber}/ratings")
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktSeason->ratings($this->traktId, $this->seasonNumber);
    
    expect($result)->toBeArray();
});

test('stats method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/{$this->seasonNumber}/stats")
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktSeason->stats($this->traktId, $this->seasonNumber);
    
    expect($result)->toBeArray();
});

test('watching method calls client with correct parameters', function (bool $extended, ?string $level) {
    $extendedParams = $extended ? ['extended' => $level ?: 'full'] : [];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with($extended, $level)
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/{$this->seasonNumber}/watching", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktSeason->watching($this->traktId, $this->seasonNumber, $extended, $level);
    
    expect($result)->toBeArray();
})->with([
    [false, null],
    [true, 'full'],
    [true, 'metadata']
]);

test('videos method calls client with correct parameters', function (bool $extended, ?string $level) {
    $extendedParams = $extended ? ['extended' => $level ?: 'full'] : [];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with($extended, $level)
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/{$this->seasonNumber}/videos", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktSeason->videos($this->traktId, $this->seasonNumber, $extended, $level);
    
    expect($result)->toBeArray();
})->with([
    [false, null],
    [true, 'full'],
    [true, 'metadata']
]);

test('all method returns properly formatted season data', function () {
    $expectedData = [
        [
            'number' => 1,
            'ids' => [
                'trakt' => 61430,
                'tvdb' => 30272,
                'tmdb' => 3577,
                'imdb' => ''
            ],
            'episode_count' => 7,
            'aired_episodes' => 7,
            'title' => 'Season 1',
            'overview' => 'First season of Breaking Bad',
            'first_aired' => '2008-01-20T07:00:00.000Z',
            'network' => 'AMC'
        ]
    ];
    
    $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktSeason->all($this->traktId);
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('number')
        ->toHaveKey('ids')
        ->toHaveKey('episode_count')
        ->toHaveKey('aired_episodes');
});

test('episodes method returns properly formatted episode data', function () {
    $expectedData = [
        [
            'season' => 1,
            'number' => 1,
            'title' => 'Pilot',
            'ids' => [
                'trakt' => 16,
                'tvdb' => 349232,
                'imdb' => 'tt0959621',
                'tmdb' => 62085,
                'tvrage' => 637041
            ],
            'overview' => 'A high school chemistry teacher is diagnosed with terminal lung cancer and turns to a life of crime.',
            'first_aired' => '2008-01-20T07:00:00.000Z',
            'runtime' => 58
        ]
    ];
    
    $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktSeason->episodes($this->traktId, $this->seasonNumber);
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('season')
        ->toHaveKey('number')
        ->toHaveKey('title')
        ->toHaveKey('ids')
        ->toHaveKey('overview');
});

test('season methods handle error responses', function (string $method, array $args) {
    if (in_array($method, ['all', 'info', 'episodes', 'people', 'watching', 'videos'])) {
        $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
    }
    
    $this->mockClient->shouldReceive('get')
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    $methodCall = fn() => $this->traktSeason->{$method}(...$args);
    
    expect($methodCall)->toThrow(Exception::class, 'API error');
})->with([
    ['all', ['breaking-bad', false, null]],
    ['info', ['breaking-bad', false, null]],
    ['episodes', ['breaking-bad', 1, false, null]],
    ['people', ['breaking-bad', 1, false, null]],
    ['ratings', ['breaking-bad', 1]],
    ['stats', ['breaking-bad', 1]],
    ['watching', ['breaking-bad', 1, false, null]],
    ['videos', ['breaking-bad', 1, false, null]]
]);

test('season methods handle empty response correctly', function (string $method, array $args) {
    if (in_array($method, ['all', 'info', 'episodes', 'people', 'watching', 'videos'])) {
        $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
    }
    
    $this->mockClient->shouldReceive('get')
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $methodCall = fn() => $this->traktSeason->{$method}(...$args);
    
    expect($methodCall())->toBeArray()->toBeEmpty();
})->with([
    ['all', ['breaking-bad', false, null]],
    ['info', ['breaking-bad', false, null]],
    ['episodes', ['breaking-bad', 1, false, null]],
    ['people', ['breaking-bad', 1, false, null]],
    ['ratings', ['breaking-bad', 1]],
    ['stats', ['breaking-bad', 1]],
    ['watching', ['breaking-bad', 1, false, null]],
    ['videos', ['breaking-bad', 1, false, null]]
]);
