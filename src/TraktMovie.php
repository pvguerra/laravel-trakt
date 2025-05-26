<?php

namespace Pvguerra\LaravelTrakt;

use Exception;

class TraktMovie
{
    public function __construct(protected Client $client)
    {
    }

    /**
     * Returns a single movie's details.
     *
     * https://trakt.docs.apiary.io/#reference/movies/summary
     * @param string|int $traktId
     * @return array
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function get(string|int $traktId, bool $extended = false, ?string $level = 'full'): array
    {
        $params = [];

        if ($extended && $level) {
            $params[] = "extended={$level}";
        }

        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("movies/{$traktId}{$queryString}")->json();
    }

    /**
     * Returns all title aliases for a movie. Includes country where name is different.
     *
     * https://trakt.docs.apiary.io/#reference/movies/aliases
     * @param string|int $traktId
     * @return array
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function aliases(string|int $traktId): array
    {
        return $this->client->get("movies/{$traktId}/aliases")->json();
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
     * @return array
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function trending(
        int $page = 1,
        int $limit = 10,
        bool $extended = false,
        ?string $level = 'full',
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);

        if ($extended && $level) {
            $params[] = "extended={$level}";
        }

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("movies/trending{$queryString}")->json();
    }

    /**
     * Returns the most popular movies.
     * Popularity is calculated using the rating percentage and the number of ratings.
     *
     * https://trakt.docs.apiary.io/#reference/movies/popular
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function popular(?string $filters = null, int $page = 1, int $limit = 10): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("movies/popular{$queryString}")->json();
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
     * @return array
     */
    public function recommended(
        string $period = 'weekly',
        ?string $filters = null,
        int $page = 1,
        int $limit = 10
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("movies/recommended/{$period}{$queryString}")->json();
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
     * @return array
     */
    public function played(
        string $period = 'weekly',
        ?string $filters = null,
        int $page = 1,
        int $limit = 10
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("movies/played/{$period}{$queryString}")->json();
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
     * @return array
     */
    public function watched(
        string $period = 'weekly',
        ?string $filters = null,
        int $page = 1,
        int $limit = 10
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("movies/watched/{$period}{$queryString}")->json();
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
     * @return array
     */
    public function collected(
        string $period = 'weekly',
        ?string $filters = null,
        int $page = 1,
        int $limit = 10
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("movies/collected/{$period}{$queryString}")->json();
    }

    /**
     * Returns the most anticipated movies based on the number of lists a movie appears on.
     *
     * https://trakt.docs.apiary.io/#reference/movies/anticipated
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function anticipated(?string $filters = null, int $page = 1, int $limit = 10): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);

        if ($filters) {
            $params[] = $filters;
        }
        
        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("movies/anticipated{$queryString}")->json();
    }

    /**
     * Returns the top 10 grossing movies in the U.S. box office last weekend. Updated every Monday morning.
     *
     * https://trakt.docs.apiary.io/#reference/movies/boxoffice
     * @return array
     */
    public function boxOffice(): array
    {
        return $this->client->get("movies/boxoffice")->json();
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
     * @return array
     */
    public function releases(string|int $traktId, string $country = 'us'): array
    {
        return $this->client->get("movies/{$traktId}/releases/{$country}")->json();
    }

    /**
     * Returns all translations for a movie, including language and translated values for title, tagline and overview.
     *
     * https://trakt.docs.apiary.io/#reference/movies/translations
     * @param string|int $traktId
     * @param string $language
     * @return array
     */
    public function translations(string|int $traktId, string $language = 'pt'): array
    {
        return $this->client->get("movies/{$traktId}/translations/{$language}")->json();
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
     * @return array
     */
    public function lists(
        string|int $traktId,
        string $type = 'personal',
        string $sort = 'popular',
        int $page = 1,
        int $limit = 10
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);
        
        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("movies/{$traktId}/lists/{$type}/{$sort}{$queryString}")->json();
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
     * @return array
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function people(string|int $traktId, bool $extended = true, ?string $level = 'full'): array
    {
        $params = [];
        
        if ($extended && $level) {
            $params[] = "extended={$level}";
        }
        
        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("movies/{$traktId}/people{$queryString}")->json();
    }

    /**
     * Returns rating (between 0 and 10) and distribution for a movie.
     *
     * https://trakt.docs.apiary.io/#reference/movies/ratings
     * @param string|int $traktId
     * @return array
     */
    public function ratings(string|int $traktId): array
    {
        return $this->client->get("movies/{$traktId}/ratings")->json();
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
     * @return array
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function related(string|int $traktId, int $page = 1, int $limit = 10, bool $extended = true, ?string $level = 'full'): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);

        if ($extended && $level) {
            $params[] = "extended={$level}";
        }
        
        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("movies/{$traktId}/related{$queryString}")->json();
    }

    /**
     * Returns lots of movie stats.
     *
     * https://trakt.docs.apiary.io/#reference/movies/stats
     * @param string|int $traktId
     * @return array
     */
    public function stats(string|int $traktId): array
    {
        return $this->client->get("movies/{$traktId}/stats")->json();
    }

    /**
     * Returns all users watching this movie right now.
     *
     * https://trakt.docs.apiary.io/#reference/movies/watching
     * @param string|int $traktId
     * @param bool $extended
     * @param string|null $level
     * @return array
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function watching(string|int $traktId, bool $extended = true, ?string $level = 'full'): array
    {
        $params = [];
        
        if ($extended && $level) {
            $params[] = "extended={$level}";
        }
        
        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("movies/{$traktId}/watching{$queryString}")->json();
    }
}
