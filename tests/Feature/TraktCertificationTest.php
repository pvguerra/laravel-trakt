<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktCertification;

/**
 * TraktCertification test suite
 */

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktCertification = new TraktCertification($this->mockClient);
});

test('it can be instantiated with client interface', function () {
    expect($this->traktCertification)->toBeInstanceOf(TraktCertification::class);
});

test('certifications method calls client get with correct endpoint', function (string $type) {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("certifications/{$type}")
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktCertification->certifications($type);
    
    expect($result)->toBeArray();
})->with([
    'movies',
    'shows'
]);

test('certifications method returns properly formatted response data', function () {
    $expectedData = [
        'us' => [
            ['name' => 'G', 'slug' => 'g', 'description' => 'General Audiences'],
            ['name' => 'PG', 'slug' => 'pg', 'description' => 'Parental Guidance Suggested'],
            ['name' => 'PG-13', 'slug' => 'pg-13', 'description' => 'Parents Strongly Cautioned']
        ]
    ];
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('certifications/movies')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktCertification->certifications('movies');
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result['us'])
        ->toBeArray()
        ->toHaveCount(3);
        
    expect($result['us'][0])
        ->toHaveKey('name')
        ->toHaveKey('slug')
        ->toHaveKey('description');
});

test('certifications method handles empty response correctly', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('certifications/movies')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktCertification->certifications('movies');
    
    expect($result)
        ->toBeArray()
        ->toBeEmpty();
});

test('certifications method handles error responses', function () {
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with('certifications/movies')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    expect(fn() => $this->traktCertification->certifications('movies'))
        ->toThrow(Exception::class, 'API error');
});
