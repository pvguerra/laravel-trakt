<?php

namespace Pvguerra\LaravelTrakt;

class TraktCalendar
{
    public function __construct(protected Client $client)
    {
    }

    /**
     * Returns all shows airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-shows/get-shows
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @return array
     */
    public function shows(string $startDate, int $days, bool $extended = true, ?string $level = 'full'): array
    {
        $params = [];
        
        if ($extended && $level) {
            $params['extended'] = $level;
        }
        
        return $this->client->get("calendars/my/shows/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all new show premieres (season 1, episode 1) airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-shows/get-new-shows
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @return array
     */
    public function newShows(string $startDate, int $days, bool $extended = true, ?string $level = 'full'): array
    {
        $params = [];
        
        if ($extended && $level) {
            $params['extended'] = $level;
        }
        
        return $this->client->get("calendars/my/shows/new/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all show premieres (any season, episode 1) airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-season-premieres/get-season-premieres
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @return array
     */
    public function seasonPremieres(string $startDate, int $days, bool $extended = true, ?string $level = 'full'): array
    {
        $params = [];
        
        if ($extended && $level) {
            $params['extended'] = $level;
        }
        
        return $this->client->get("calendars/my/shows/premieres/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all movies with a release date during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-movies/get-movies
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @return array
     */
    public function movies(string $startDate, int $days, bool $extended = true, ?string $level = 'full'): array
    {
        $params = [];
        
        if ($extended && $level) {
            $params['extended'] = $level;
        }
        
        return $this->client->get("calendars/my/movies/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all shows airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/all-shows/get-shows
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @return array
     */
    public function allShows(string $startDate, int $days, bool $extended = true, ?string $level = 'full'): array
    {
        $params = [];
        
        if ($extended && $level) {
            $params['extended'] = $level;
        }
        
        return $this->client->get("calendars/all/shows/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all new show premieres (season 1, episode 1) airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-shows/get-new-shows
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @return array
     */
    public function allNewShows(string $startDate, int $days, bool $extended = true, ?string $level = 'full'): array
    {
        $params = [];
        
        if ($extended && $level) {
            $params['extended'] = $level;
        }
        
        return $this->client->get("calendars/all/shows/new/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all show premieres (any season, episode 1) airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/all-season-premieres/get-season-premieres
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @return array
     */
    public function allSeasonPremieres(string $startDate, int $days, bool $extended = true, ?string $level = 'full'): array
    {
        $params = [];
        
        if ($extended && $level) {
            $params['extended'] = $level;
        }
        
        return $this->client->get("calendars/all/shows/premieres/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all movies with a release date during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-movies/get-movies
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @return array
     */
    public function allMovies(string $startDate, int $days, bool $extended = true, ?string $level = 'full'): array
    {
        $params = [];
        
        if ($extended && $level) {
            $params['extended'] = $level;
        }
        
        return $this->client->get("calendars/all/movies/{$startDate}/{$days}", $params)->json();
    }
}
