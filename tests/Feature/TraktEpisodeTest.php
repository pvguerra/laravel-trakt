<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktEpisode;

/**
 * TraktEpisode test suite
 */

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktEpisode = new TraktEpisode($this->mockClient);
    
    // Common test data
    $this->traktId = 'breaking-bad';
    $this->seasonNumber = 1;
    $this->episodeNumber = 1;
});

test('it can be instantiated with client interface', function () {
    expect($this->traktEpisode)->toBeInstanceOf(TraktEpisode::class);
});

test('get method calls client with correct parameters', function (bool $extended, ?string $level) {
    // Setup expected parameters
    $params = ['param1' => 'value1'];
    
    // Mock the parameter building methods
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with($extended, $level)
        ->andReturn($params);
    
    // Mock the get request
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/{$this->seasonNumber}/episodes/{$this->episodeNumber}", $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    // Call the method
    $result = $this->traktEpisode->get($this->traktId, $this->seasonNumber, $this->episodeNumber, $extended, $level);
    
    expect($result)->toBeArray();
})->with([
    [false, null],
    [true, 'full']
]);

test('people method calls client with correct endpoint', function () {
    $params = ['extended' => 'full'];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($params);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/{$this->seasonNumber}/episodes/{$this->episodeNumber}/people", $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktEpisode->people($this->traktId, $this->seasonNumber, $this->episodeNumber, true, 'full');
    
    expect($result)->toBeArray();
});

test('ratings method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/{$this->seasonNumber}/episodes/{$this->episodeNumber}/ratings")
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktEpisode->ratings($this->traktId, $this->seasonNumber, $this->episodeNumber);
    
    expect($result)->toBeArray();
});

test('stats method calls client with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/{$this->seasonNumber}/episodes/{$this->episodeNumber}/stats")
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktEpisode->stats($this->traktId, $this->seasonNumber, $this->episodeNumber);
    
    expect($result)->toBeArray();
});

test('watching method calls client with correct endpoint', function () {
    $params = ['extended' => 'full'];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($params);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/{$this->seasonNumber}/episodes/{$this->episodeNumber}/watching", $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktEpisode->watching($this->traktId, $this->seasonNumber, $this->episodeNumber, true, 'full');
    
    expect($result)->toBeArray();
});

test('get method returns properly formatted response data', function () {
    $expectedData = [
        'season' => 1,
        'number' => 1,
        'title' => 'Pilot',
        'ids' => [
            'trakt' => 16,
            'tvdb' => 349232,
            'imdb' => 'tt0959621'
        ],
        'first_aired' => '2008-01-20T02:00:00.000Z',
        'overview' => 'A high school chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine.'
    ];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("shows/{$this->traktId}/seasons/{$this->seasonNumber}/episodes/{$this->episodeNumber}", [])
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktEpisode->get($this->traktId, $this->seasonNumber, $this->episodeNumber);
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result)
        ->toHaveKey('season')
        ->toHaveKey('number')
        ->toHaveKey('title')
        ->toHaveKey('ids');
});

test('episode methods handle error responses', function (string $method) {
    $params = [];
    
    if (in_array($method, ['get', 'people', 'watching'])) {
        $this->mockClient->shouldReceive('buildExtendedParams')
            ->andReturn($params);
    }
    
    $this->mockClient->shouldReceive('get')
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    $methodCall = match($method) {
        'get', 'people', 'watching' => fn() => $this->traktEpisode->{$method}($this->traktId, $this->seasonNumber, $this->episodeNumber, false, null),
        default => fn() => $this->traktEpisode->{$method}($this->traktId, $this->seasonNumber, $this->episodeNumber)
    };
    
    expect($methodCall)->toThrow(Exception::class, 'API error');
})->with([
    'get',
    'people',
    'ratings',
    'stats',
    'watching'
]);
