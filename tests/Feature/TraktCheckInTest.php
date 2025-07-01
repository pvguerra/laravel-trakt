<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktCheckIn;

/**
 * TraktCheckIn test suite
 */

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktCheckIn = new TraktCheckIn($this->mockClient);
});

test('it can be instantiated with client interface', function () {
    expect($this->traktCheckIn)->toBeInstanceOf(TraktCheckIn::class);
});

test('checkIn method calls client post with correct endpoint and data', function () {
    $checkInData = [
        'movie' => [
            'ids' => [
                'trakt' => 12345
            ]
        ],
        'sharing' => [
            'facebook' => false,
            'twitter' => true
        ]
    ];
    
    $expectedResponse = [
        'id' => 3373536,
        'watched_at' => '2025-06-27T10:17:04.000Z',
        'movie' => [
            'title' => 'The Matrix',
            'year' => 1999,
            'ids' => [
                'trakt' => 12345,
                'slug' => 'the-matrix-1999',
                'imdb' => 'tt0133093',
                'tmdb' => 603
            ]
        ]
    ];
    
    $this->mockClient->shouldReceive('post')
        ->once()
        ->with('checkin', $checkInData)
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedResponse);
    
    $result = $this->traktCheckIn->checkIn($checkInData);
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedResponse);
});

test('checkIn method handles episode data correctly', function () {
    $checkInData = [
        'episode' => [
            'ids' => [
                'trakt' => 54321
            ]
        ]
    ];
    
    $expectedResponse = [
        'id' => 3373537,
        'watched_at' => '2025-06-27T10:17:04.000Z',
        'episode' => [
            'season' => 1,
            'number' => 1,
            'title' => 'Pilot',
            'ids' => [
                'trakt' => 54321
            ]
        ],
        'show' => [
            'title' => 'Breaking Bad',
            'year' => 2008
        ]
    ];
    
    $this->mockClient->shouldReceive('post')
        ->once()
        ->with('checkin', $checkInData)
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedResponse);
    
    $result = $this->traktCheckIn->checkIn($checkInData);
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedResponse);
});

test('deleteCheckIns method calls client delete with correct endpoint', function () {
    $expectedResponse = [
        'deleted' => true,
        'id' => 3373536
    ];
    
    $this->mockClient->shouldReceive('delete')
        ->once()
        ->with('checkin')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedResponse);
    
    $result = $this->traktCheckIn->deleteCheckIns();
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedResponse);
});

test('checkIn method handles error responses', function () {
    $checkInData = [
        'movie' => [
            'ids' => [
                'trakt' => 12345
            ]
        ]
    ];
    
    $this->mockClient->shouldReceive('post')
        ->once()
        ->with('checkin', $checkInData)
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    expect(fn() => $this->traktCheckIn->checkIn($checkInData))
        ->toThrow(Exception::class, 'API error');
});

test('deleteCheckIns method handles error responses', function () {
    $this->mockClient->shouldReceive('delete')
        ->once()
        ->with('checkin')
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    expect(fn() => $this->traktCheckIn->deleteCheckIns())
        ->toThrow(Exception::class, 'API error');
});
