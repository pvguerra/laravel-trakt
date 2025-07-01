<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktLanguage;

/**
 * TraktLanguage test suite
 */

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktLanguage = new TraktLanguage($this->mockClient);
});

test('it can be instantiated with client interface', function () {
    expect($this->traktLanguage)->toBeInstanceOf(TraktLanguage::class);
});

test('languages method calls client get with correct endpoint', function (string $type) {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("languages/{$type}")
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktLanguage->languages($type);
    
    expect($result)->toBeArray();
})->with([
    'movies',
    'shows'
]);

test('languages method returns properly formatted response data', function () {
    $expectedData = [
        ['name' => 'English', 'code' => 'en'],
        ['name' => 'Spanish', 'code' => 'es'],
        ['name' => 'French', 'code' => 'fr']
    ];
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('languages/movies')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktLanguage->languages('movies');
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('name')
        ->toHaveKey('code');
});

test('languages method handles empty response correctly', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('languages/movies')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktLanguage->languages('movies');
    
    expect($result)
        ->toBeArray()
        ->toBeEmpty();
});

test('languages method handles error responses', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('languages/movies')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    expect(fn() => $this->traktLanguage->languages('movies'))
        ->toThrow(Exception::class, 'API error');
});
