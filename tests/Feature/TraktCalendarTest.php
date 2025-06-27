<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktCalendar;

/**
 * TraktCalendar test suite
 */

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktCalendar = new TraktCalendar($this->mockClient);
    
    // Common test data
    $this->startDate = '2025-06-27';
    $this->days = 7;
});

test('it can be instantiated with client interface', function () {
    expect($this->traktCalendar)->toBeInstanceOf(TraktCalendar::class);
});

test('myShows method calls client with correct parameters', function (bool $extended, ?string $level, ?string $filters) {
    // Setup expected parameters
    $params = ['param1' => 'value1'];
    $filteredParams = ['param1' => 'value1', 'filter' => 'applied'];
    
    // Mock the parameter building methods
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with($extended, $level)
        ->andReturn($params);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->with($params, $filters)
        ->andReturn($filteredParams);
    
    // Mock the get request
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("calendars/my/shows/{$this->startDate}/{$this->days}", $filteredParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    // Call the method
    $result = $this->traktCalendar->myShows($this->startDate, $this->days, $extended, $level, $filters);
    
    expect($result)->toBeArray();
})->with([
    [false, null, null],
    [true, 'full', null],
    [true, 'full', 'countries=us,uk']
]);

test('myNewShows method calls client with correct endpoint', function () {
    $params = [];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($params);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->andReturn($params);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("calendars/my/shows/new/{$this->startDate}/{$this->days}", $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktCalendar->myNewShows($this->startDate, $this->days);
    
    expect($result)->toBeArray();
});

test('mySeasonPremieres method calls client with correct endpoint', function () {
    $params = [];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($params);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->andReturn($params);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("calendars/my/shows/premieres/{$this->startDate}/{$this->days}", $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktCalendar->mySeasonPremieres($this->startDate, $this->days);
    
    expect($result)->toBeArray();
});

test('allShows method calls client with correct endpoint', function () {
    $params = [];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($params);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->once()
        ->andReturn($params);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("calendars/all/shows/{$this->startDate}/{$this->days}", $params)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktCalendar->allShows($this->startDate, $this->days);
    
    expect($result)->toBeArray();
});

test('calendar methods handle error responses', function (string $method) {
    $params = [];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->andReturn($params);
        
    $this->mockClient->shouldReceive('addFiltersToParams')
        ->andReturn($params);
    
    $this->mockClient->shouldReceive('get')
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    expect(fn() => $this->traktCalendar->{$method}($this->startDate, $this->days))
        ->toThrow(Exception::class, 'API error');
})->with([
    'myShows',
    'myNewShows',
    'mySeasonPremieres',
    'myFinales',
    'myMovies',
    'myDVD',
    'allShows',
    'allNewShows',
    'allSeasonPremieres',
    'allFinales',
    'allMovies',
    'allDVD'
]);
