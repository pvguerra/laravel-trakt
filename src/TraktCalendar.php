<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktCalendar
{
    public function __construct(protected ClientInterface $client)
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
     * @param ?string $filters
     * @return array
     */
    public function myShows(
        string $startDate,
        int $days,
        bool $extended = false,
        ?string $level = null,
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        $params = $this->client->addFiltersToParams($params, $filters);
        
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
     * @param ?string $filters
     * @return array
     */
    public function myNewShows(
        string $startDate,
        int $days,
        bool $extended = false,
        ?string $level = null,
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        $params = $this->client->addFiltersToParams($params, $filters);
        
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
     * @param ?string $filters
     * @return array
     */
    public function mySeasonPremieres(
        string $startDate,
        int $days,
        bool $extended = false,
        ?string $level = null,
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("calendars/my/shows/premieres/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all show finales (mid_season_finale, season_finale, series_finale) airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-finales/get-finales
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @param ?string $filters
     * @return array
     */
    public function myFinales(
        string $startDate,
        int $days,
        bool $extended = false,
        ?string $level = null,
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("calendars/my/shows/finales/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all movies with a release date during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-movies/get-movies
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @param ?string $filters
     * @return array
     */
    public function myMovies(
        string $startDate,
        int $days,
        bool $extended = false,
        ?string $level = null,
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("calendars/my/movies/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all movies with a DVD release date during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-dvd/get-dvd-releases
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @param ?string $filters
     * @return array
     */
    public function myDVD(
        string $startDate,
        int $days,
        bool $extended = false,
        ?string $level = null,
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("calendars/my/dvd/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all shows airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/all-shows/get-shows
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @param ?string $filters
     * @return array
     */
    public function allShows(
        string $startDate,
        int $days,
        bool $extended = false,
        ?string $level = null,
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        $params = $this->client->addFiltersToParams($params, $filters);
        
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
    public function allNewShows(
        string $startDate,
        int $days,
        bool $extended = false,
        ?string $level = null,
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        $params = $this->client->addFiltersToParams($params, $filters);
        
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
    public function allSeasonPremieres(
        string $startDate,
        int $days,
        bool $extended = false,
        ?string $level = null,
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("calendars/all/shows/premieres/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all show finales (mid_season_finale, season_finale, series_finale) airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/all-finales/get-finales
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @param ?string $filters
     * @return array
     */
    public function allFinales(
        string $startDate,
        int $days,
        bool $extended = false,
        ?string $level = null,
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("calendars/all/shows/finales/{$startDate}/{$days}", $params)->json();
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
    public function allMovies(
        string $startDate,
        int $days,
        bool $extended = false,
        ?string $level = null,
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("calendars/all/movies/{$startDate}/{$days}", $params)->json();
    }

    /**
     * Returns all movies with a DVD release date during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-dvd/get-dvd-releases
     * @param string $startDate
     * @param int $days
     * @param bool $extended
     * @param string|null $level
     * @param ?string $filters
     * @return array
     */
    public function allDVD(
        string $startDate,
        int $days,
        bool $extended = false,
        ?string $level = null,
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("calendars/all/dvd/{$startDate}/{$days}", $params)->json();
    }
}
