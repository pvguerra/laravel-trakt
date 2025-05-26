<?php

namespace Pvguerra\LaravelTrakt;

use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;

class TraktMovie extends LaravelTrakt
{
    /**
     * Build query string from parameters array
     *
     * @param array $params
     * @return string
     */
    private function buildQueryString(array $params): string
    {
        return count($params) > 0 ? '?' . implode('&', $params) : '';
    }
    
    /**
     * Build pagination parameters
     *
     * @param int $page
     * @param int $limit
     * @return array
     */
    private function buildPaginationParams(int $page, int $limit): array
    {
        $params = [];
        $params[] = "page={$page}";
        $params[] = "limit={$limit}";
        return $params;
    }
    
    /**
     * Make API request and handle exceptions
     *
     * @param string $uri
     * @return JsonResponse
     * @throws ConnectionException
     * @throws Exception
     */
    private function makeRequest(string $uri): JsonResponse
    {
        try {
            $response = $this->client->get($uri)->throw()->json();
            return $response;
        } catch (ConnectionException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Returns a single movie's details.
     *
     * https://trakt.docs.apiary.io/#reference/movies/summary
     * @param string|int $traktId
     * @return JsonResponse
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function get(string|int $traktId, bool $extended = false, ?string $level = 'full'): JsonResponse
    {
        $params = [];

        if ($extended && $level) {
            $params[] = "extended={$level}";
        }

        $queryString = $this->buildQueryString($params);
        return $this->makeRequest("movies/{$traktId}{$queryString}");
    }

    /**
     * Returns all title aliases for a movie. Includes country where name is different.
     *
     * https://trakt.docs.apiary.io/#reference/movies/aliases
     * @param string|int $traktId
     * @return JsonResponse
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function aliases(string|int $traktId): JsonResponse
    {
        return $this->makeRequest("movies/{$traktId}/aliases");
    }

    /**
     * Returns all movies being watched right now. Movies with the most users are returned first.
     *
     * https://trakt.docs.apiary.io/#reference/movies/trending
     * @param int $page
     * @param int $limit
     * @param bool $extended
     * @param ?string $level
     * @param ?string $filters
     * @return JsonResponse
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function trending(
        int $page = 1,
        int $limit = 10,
        bool $extended = false,
        ?string $level = 'full',
        ?string $filters = null
    ): JsonResponse
    {
        $params = $this->buildPaginationParams($page, $limit);

        if ($extended && $level) {
            $params[] = "extended={$level}";
        }

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->buildQueryString($params);
        return $this->makeRequest("movies/trending{$queryString}");
    }

    /**
     * Returns the most popular movies.
     * Popularity is calculated using the rating percentage and the number of ratings.
     *
     * https://trakt.docs.apiary.io/#reference/movies/popular
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function popular(?string $filters = null, int $page = 1, int $limit = 10): JsonResponse
    {
        $params = $this->buildPaginationParams($page, $limit);

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->buildQueryString($params);
        return $this->makeRequest("movies/popular{$queryString}");
    }

    /**
     * Returns the most recommended movies in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/movies/recommended
     * @param string $period
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function recommended(
        string $period = 'weekly',
        ?string $filters = null,
        int $page = 1,
        int $limit = 10
    ): JsonResponse
    {
        $params = $this->buildPaginationParams($page, $limit);

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->buildQueryString($params);
        return $this->makeRequest("movies/recommended/{$period}{$queryString}");
    }

    /**
     * Returns the most played (a single user can watch multiple times) movies in the specified time period,
     * defaulting to weekly. All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/movies/played
     * @param string $period
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function played(
        string $period = 'weekly',
        ?string $filters = null,
        int $page = 1,
        int $limit = 10
    ): JsonResponse
    {
        $params = $this->buildPaginationParams($page, $limit);

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->buildQueryString($params);
        return $this->makeRequest("movies/played/{$period}{$queryString}");
    }

    /**
     * Returns the most watched (unique users) movies in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/movies/watched
     * @param string $period
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function watched(
        string $period = 'weekly',
        ?string $filters = null,
        int $page = 1,
        int $limit = 10
    ): JsonResponse
    {
        $params = $this->buildPaginationParams($page, $limit);

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->buildQueryString($params);
        return $this->makeRequest("movies/watched/{$period}{$queryString}");
    }

    /**
     * Returns the most collected (unique users) movies in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/movies/collected
     * @param string $period
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function collected(
        string $period = 'weekly',
        ?string $filters = null,
        int $page = 1,
        int $limit = 10
    ): JsonResponse
    {
        $params = $this->buildPaginationParams($page, $limit);

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->buildQueryString($params);
        return $this->makeRequest("movies/collected/{$period}{$queryString}");
    }

    /**
     * Returns the most anticipated movies based on the number of lists a movie appears on.
     *
     * https://trakt.docs.apiary.io/#reference/movies/anticipated
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function anticipated(?string $filters = null, int $page = 1, int $limit = 10): JsonResponse
    {
        $params = $this->buildPaginationParams($page, $limit);

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->buildQueryString($params);
        return $this->makeRequest("movies/anticipated{$queryString}");
    }

    /**
     * Returns the top 10 grossing movies in the U.S. box office last weekend. Updated every Monday morning.
     *
     * https://trakt.docs.apiary.io/#reference/movies/boxoffice
     * @return JsonResponse
     */
    public function boxOffice(): JsonResponse
    {
        return $this->makeRequest("movies/boxoffice");
    }

    /**
     * Returns all releases for a movie including country, certification, release date, release type, and note.
     * The release type can be set to unknown, premiere, limited, theatrical, digital, physical, or tv.
     * The note might have optional info such as the film festival name for a premiere release or Blu-ray specs
     * for a physical release. We pull this info from TMDB.
     *
     * https://trakt.docs.apiary.io/#reference/movies/releases
     * @param string|int $traktId
     * @param string $country
     * @return JsonResponse
     */
    public function releases(string|int $traktId, string $country = 'us'): JsonResponse
    {
        return $this->makeRequest("movies/{$traktId}/releases/{$country}");
    }

    /**
     * Returns all translations for a movie, including language and translated values for title, tagline and overview.
     *
     * https://trakt.docs.apiary.io/#reference/movies/translations
     * @param string|int $traktId
     * @param string $language
     * @return JsonResponse
     */
    public function translations(string|int $traktId, string $language = 'pt'): JsonResponse
    {
        return $this->makeRequest("movies/{$traktId}/translations/{$language}");
    }

    /**
     * Returns all lists that contain this movie. By default, personal lists are returned sorted by the most popular.
     *
     * https://trakt.docs.apiary.io/#reference/movies/lists
     * @param string|int $traktId
     * @param string $type
     * @param string $sort
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function lists(
        string|int $traktId,
        string $type = 'personal',
        string $sort = 'popular',
        int $page = 1,
        int $limit = 10
    ): JsonResponse
    {
        $params = $this->buildPaginationParams($page, $limit);
        
        $queryString = $this->buildQueryString($params);
        return $this->makeRequest("movies/{$traktId}/lists/{$type}/{$sort}{$queryString}");
    }

    /**
     * Returns all cast and crew for a movie.
     * Each cast member will have a characters array and a standard person object.
     * The crew object will be broken up by department into production, art, crew, costume & make-up,
     * directing, writing, sound, camera, visual effects, lighting, and editing (if there are people
     * for those crew positions). Each of those members will have a jobs array and a standard person object.
     *
     * https://trakt.docs.apiary.io/#reference/movies/people
     * @param string|int $traktId
     * @param bool $extended
     * @param string|null $level
     * @return JsonResponse
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function people(string|int $traktId, bool $extended = true, ?string $level = 'full'): JsonResponse
    {
        $params = [];
        
        if ($extended && $level) {
            $params[] = "extended={$level}";
        }
        
        $queryString = $this->buildQueryString($params);
        return $this->makeRequest("movies/{$traktId}/people{$queryString}");
    }

    /**
     * Returns rating (between 0 and 10) and distribution for a movie.
     *
     * https://trakt.docs.apiary.io/#reference/movies/ratings
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function ratings(string|int $traktId): JsonResponse
    {
        return $this->makeRequest("movies/{$traktId}/ratings");
    }

    /**
     * Returns related and similar movies.
     *
     * https://trakt.docs.apiary.io/#reference/movies/related
     * @param string|int $traktId
     * @param int $page
     * @param int $limit
     * @param bool $extended
     * @param string|null $level
     * @return JsonResponse
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function related(string|int $traktId, int $page = 1, int $limit = 10, bool $extended = true, ?string $level = 'full'): JsonResponse
    {
        $params = $this->buildPaginationParams($page, $limit);

        if ($extended && $level) {
            $params[] = "extended={$level}";
        }
        
        $queryString = $this->buildQueryString($params);
        return $this->makeRequest("movies/{$traktId}/related{$queryString}");
    }

    /**
     * Returns lots of movie stats.
     *
     * https://trakt.docs.apiary.io/#reference/movies/stats
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function stats(string|int $traktId): JsonResponse
    {
        return $this->makeRequest("movies/{$traktId}/stats");
    }

    /**
     * Returns all users watching this movie right now.
     *
     * https://trakt.docs.apiary.io/#reference/movies/watching
     * @param string|int $traktId
     * @param bool $extended
     * @param string|null $level
     * @return JsonResponse
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function watching(string|int $traktId, bool $extended = true, ?string $level = 'full'): JsonResponse
    {
        $params = [];
        
        if ($extended && $level) {
            $params[] = "extended={$level}";
        }
        
        $queryString = $this->buildQueryString($params);
        return $this->makeRequest("movies/{$traktId}/watching{$queryString}");
    }
}
