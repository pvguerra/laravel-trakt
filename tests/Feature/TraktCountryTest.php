<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktCountry;

/**
 * TraktCountry test suite
 */

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktCountry = new TraktCountry($this->mockClient);
});

test('it can be instantiated with client interface', function () {
    expect($this->traktCountry)->toBeInstanceOf(TraktCountry::class);
});

test('countries method calls client get with correct endpoint', function (string $type) {
    $this->mockResponse->shouldReceive('json')->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("countries/{$type}")
        ->andReturn($this->mockResponse);
    
    $result = $this->traktCountry->countries($type);
    
    expect($result)->toBeArray();
})->with([
    'movies',
    'shows'
]);

test('countries method returns properly formatted response data', function () {
    $expectedData = [
        ['name' => 'United States', 'code' => 'us'],
        ['name' => 'United Kingdom', 'code' => 'uk'],
        ['name' => 'Canada', 'code' => 'ca']
    ];
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('countries/movies')
        ->andReturn($this->mockResponse);
    
    $result = $this->traktCountry->countries('movies');
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData)
        ->toHaveCount(3);
        
    expect($result[0])
        ->toHaveKey('name')
        ->toHaveKey('code');
});

test('countries method handles empty response correctly', function () {
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('countries/movies')
        ->andReturn($this->mockResponse);
    
    $result = $this->traktCountry->countries('movies');
    
    expect($result)
        ->toBeArray()
        ->toBeEmpty();
});

test('countries method handles error responses', function () {
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('countries/movies')
        ->andReturn($this->mockResponse);
    
    expect(fn() => $this->traktCountry->countries('movies'))
        ->toThrow(Exception::class, 'API error');
});
