<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktNetwork;

/**
 * TraktNetwork test suite
 */

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktNetwork = new TraktNetwork($this->mockClient);
});

test('it can be instantiated with client interface', function () {
    expect($this->traktNetwork)->toBeInstanceOf(TraktNetwork::class);
});

test('genres method calls client get with correct endpoint', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('networks')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktNetwork->genres();
    
    expect($result)->toBeArray();
});

test('genres method returns properly formatted response data', function () {
    $expectedData = [
        ['name' => 'HBO', 'logo_path' => '/path/to/hbo.png'],
        ['name' => 'Netflix', 'logo_path' => '/path/to/netflix.png'],
        ['name' => 'AMC', 'logo_path' => '/path/to/amc.png']
    ];
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('networks')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktNetwork->genres();
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result[0])
        ->toHaveKey('name');
});

test('genres method handles empty response correctly', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('networks')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktNetwork->genres();
    
    expect($result)
        ->toBeArray()
        ->toBeEmpty();
});

test('genres method handles error responses', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('networks')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    expect(fn() => $this->traktNetwork->genres())
        ->toThrow(Exception::class, 'API error');
});
