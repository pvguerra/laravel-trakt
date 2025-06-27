<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktGenre;

/**
 * TraktGenre test suite
 */

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktGenre = new TraktGenre($this->mockClient);
});

test('it can be instantiated with client interface', function () {
    expect($this->traktGenre)->toBeInstanceOf(TraktGenre::class);
});

test('genres method calls client get with correct endpoint', function (string $type) {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("genres/{$type}")
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktGenre->genres($type);
    
    expect($result)->toBeArray();
})->with([
    'movies',
    'shows'
]);

test('genres method returns properly formatted response data', function () {
    $expectedData = [
        ['name' => 'Action', 'slug' => 'action'],
        ['name' => 'Adventure', 'slug' => 'adventure'],
        ['name' => 'Comedy', 'slug' => 'comedy']
    ];
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('genres/movies')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktGenre->genres('movies');
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('name')
        ->toHaveKey('slug');
});

test('genres method handles empty response correctly', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('genres/movies')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktGenre->genres('movies');
    
    expect($result)
        ->toBeArray()
        ->toBeEmpty();
});

test('genres method handles error responses', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('genres/movies')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    expect(fn() => $this->traktGenre->genres('movies'))
        ->toThrow(Exception::class, 'API error');
});
