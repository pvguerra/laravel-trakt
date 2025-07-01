<?php

use Illuminate\Http\Client\Response;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;
use Pvguerra\LaravelTrakt\TraktPerson;

/**
 * TraktPerson test suite
 */

beforeEach(function () {
    $this->mockResponse = mock(Response::class);
    $this->mockClient = mock(ClientInterface::class);
    $this->traktPerson = new TraktPerson($this->mockClient);
    
    // Common test data
    $this->traktId = 'bryan-cranston';
    $this->page = 1;
    $this->limit = 10;
});

test('it can be instantiated with client interface', function () {
    expect($this->traktPerson)->toBeInstanceOf(TraktPerson::class);
});

test('get method calls client with correct parameters', function (bool $extended, ?string $level) {
    $extendedParams = $extended ? ['extended' => $level ?? 'full'] : [];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->with($extended, $level)
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("people/{$this->traktId}", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktPerson->get($this->traktId, $extended, $level);
    
    expect($result)->toBeArray();
})->with([
    [false, null],
    [true, 'full'],
    [true, 'metadata']
]);

test('getMovieCredits method calls client with correct parameters', function () {
    $extendedParams = ['extended' => 'full'];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("people/{$this->traktId}/movies", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktPerson->getMovieCredits($this->traktId, true, 'full');
    
    expect($result)->toBeArray();
});

test('getShowCredits method calls client with correct parameters', function () {
    $extendedParams = ['extended' => 'full'];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn($extendedParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("people/{$this->traktId}/shows", $extendedParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktPerson->getShowCredits($this->traktId, true, 'full');
    
    expect($result)->toBeArray();
});

test('lists method calls client with correct parameters', function (string $type, string $sort) {
    $paginationParams = ['page' => 1, 'limit' => 10];
    
    $this->mockClient->shouldReceive('buildPaginationParams')
        ->once()
        ->with($this->page, $this->limit)
        ->andReturn($paginationParams);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("people/{$this->traktId}/lists/{$type}/{$sort}", $paginationParams)
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn([]);
    
    $result = $this->traktPerson->lists($this->traktId, $type, $sort, $this->page, $this->limit);
    
    expect($result)->toBeArray();
})->with([
    ['personal', 'popular'],
    ['official', 'likes'],
    ['personal', 'comments']
]);

test('get method returns properly formatted person data', function () {
    $expectedData = [
        'name' => 'Bryan Cranston',
        'ids' => [
            'trakt' => 123456,
            'slug' => 'bryan-cranston',
            'imdb' => 'nm0186505',
            'tmdb' => 17419
        ],
        'biography' => 'Bryan Lee Cranston is an American actor, voice actor, writer and director.',
        'birthday' => '1956-03-07',
        'death' => null,
        'birthplace' => 'San Fernando Valley, California, USA',
        'homepage' => 'http://www.bryancranston.com/',
        'gender' => 'male',
        'updated_at' => '2023-01-01T00:00:00.000Z',
        'images' => [
            'headshot' => 'https://image.tmdb.org/t/p/original/7Jahy5LZX2Fo8fGJltMreAI49hC.jpg'
        ]
    ];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("people/{$this->traktId}", [])
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktPerson->get($this->traktId);
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result)
        ->toHaveKey('name')
        ->toHaveKey('ids')
        ->toHaveKey('biography')
        ->toHaveKey('birthday');
});

test('getMovieCredits method returns properly formatted credits data', function () {
    $expectedData = [
        'cast' => [
            [
                'character' => 'Walter White',
                'movie' => [
                    'title' => 'El Camino: A Breaking Bad Movie',
                    'year' => 2019,
                    'ids' => [
                        'trakt' => 12345,
                        'slug' => 'el-camino-a-breaking-bad-movie-2019',
                        'imdb' => 'tt9243946',
                        'tmdb' => 559969
                    ]
                ]
            ]
        ],
        'crew' => [
            'production' => [
                [
                    'job' => 'Producer',
                    'movie' => [
                        'title' => 'The Infiltrator',
                        'year' => 2016,
                        'ids' => [
                            'trakt' => 12346,
                            'slug' => 'the-infiltrator-2016',
                            'imdb' => 'tt1355631',
                            'tmdb' => 336003
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("people/{$this->traktId}/movies", [])
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktPerson->getMovieCredits($this->traktId);
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result)
        ->toHaveKey('cast')
        ->toHaveKey('crew');
        
    expect($result['cast'][0])
        ->toHaveKey('character')
        ->toHaveKey('movie');
});

test('getShowCredits method returns properly formatted credits data', function () {
    $expectedData = [
        'cast' => [
            [
                'character' => 'Walter White',
                'episode_count' => 62,
                'series_regular' => true,
                'show' => [
                    'title' => 'Breaking Bad',
                    'year' => 2008,
                    'ids' => [
                        'trakt' => 1388,
                        'slug' => 'breaking-bad',
                        'imdb' => 'tt0903747',
                        'tmdb' => 1396
                    ]
                ]
            ]
        ],
        'crew' => [
            'production' => [
                [
                    'job' => 'Producer',
                    'episode_count' => 10,
                    'show' => [
                        'title' => 'Breaking Bad',
                        'year' => 2008,
                        'ids' => [
                            'trakt' => 1388,
                            'slug' => 'breaking-bad',
                            'imdb' => 'tt0903747',
                            'tmdb' => 1396
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    $this->mockClient->shouldReceive('buildExtendedParams')
        ->once()
        ->andReturn([]);
    
    $this->mockClient->shouldReceive('get')
        ->once()
        ->with("people/{$this->traktId}/shows", [])
        ->andReturn($this->mockResponse);
    
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andReturn($expectedData);
    
    $result = $this->traktPerson->getShowCredits($this->traktId);
    
    expect($result)
        ->toBeArray()
        ->toEqual($expectedData);
        
    expect($result)
        ->toHaveKey('cast')
        ->toHaveKey('crew');
        
    expect($result['cast'][0])
        ->toHaveKey('character')
        ->toHaveKey('episode_count')
        ->toHaveKey('series_regular')
        ->toHaveKey('show');
});

test('person methods handle error responses', function (string $method, array $args) {
    // Setup mocks based on method
    if (in_array($method, ['get', 'getMovieCredits', 'getShowCredits'])) {
        $this->mockClient->shouldReceive('buildExtendedParams')->andReturn([]);
    } elseif ($method === 'lists') {
        $this->mockClient->shouldReceive('buildPaginationParams')->andReturn([]);
    }
    
    $this->mockClient->shouldReceive('get')
        ->andReturn($this->mockResponse);
        
    $this->mockResponse->shouldReceive('json')
        ->once()
        ->andThrow(new Exception('API error'));
    
    // Call the method with appropriate arguments
    $methodCall = fn() => $this->traktPerson->{$method}(...$args);
    
    expect($methodCall)->toThrow(Exception::class, 'API error');
})->with([
    ['get', ['bryan-cranston', false, null]],
    ['getMovieCredits', ['bryan-cranston', false, null]],
    ['getShowCredits', ['bryan-cranston', false, null]],
    ['lists', ['bryan-cranston', 'personal', 'popular', 1, 10]]
]);
