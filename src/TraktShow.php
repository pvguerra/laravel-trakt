<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Support\Facades\Http;

class TraktShow extends LaravelTrakt
{
    /**
     * Returns a single show's details.
     * If you request extended info, the airs object is relative to the show's country.
     * You can use the day, time, and timezone to construct your own date then convert it
     * to whatever timezone your user is in.
     *
     * https://trakt.docs.apiary.io/#reference/shows/summary
     * @param string $traktId
     * @return array
     */
    public function get(string $traktId): array
    {
        $uri = $this->apiUrl . "shows/$traktId?extended=full";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all title aliases for a show. Includes country where name is different.
     *
     * https://trakt.docs.apiary.io/#reference/shows/aliases
     * @param string $traktId
     * @return array
     */
    public function aliases(string $traktId): array
    {
        $uri = $this->apiUrl . "shows/$traktId/aliases";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all shows being watched right now. Shows with the most users are returned first.
     *
     * https://trakt.docs.apiary.io/#reference/shows/trending
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function trending(?string $filters = null, int $page = 1, int $limit = 10): array
    {
        $uri = $this->apiUrl
            . "shows/trending?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most popular shows.
     * Popularity is calculated using the rating percentage and the number of ratings.
     *
     * https://trakt.docs.apiary.io/#reference/shows/popular
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function popular(?string $filters = null, int $page = 1, int $limit = 10): array
    {
        $uri = $this->apiUrl
            . "shows/popular?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most recommended shows in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/shows/recommended
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
    ): array {
        $uri = $this->apiUrl
            . "shows/recommended/$period?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most played (a single user can watch multiple times) shows in the specified time period,
     * defaulting to weekly. All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/shows/played
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
    ): array {
        $uri = $this->apiUrl
            . "shows/played/$period?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most watched (unique users) shows in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/shows/watched
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
    ): array {
        $uri = $this->apiUrl
            . "shows/watched/$period?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most collected (unique users) shows in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/shows/collected
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
    ): array {
        $uri = $this->apiUrl
            . "shows/collected/$period?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most anticipated shows based on the number of lists a show appears on.
     *
     * https://trakt.docs.apiary.io/#reference/shows/anticipated
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function anticipated(?string $filters = null, int $page = 1, int $limit = 10): array
    {
        $uri = $this->apiUrl
            . "shows/anticipated?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all content certifications for a show, including the country.
     *
     * https://trakt.docs.apiary.io/#reference/shows/certifications
     * @param string $traktId
     * @return array
     */
    public function certifications(string $traktId): array
    {
        $uri = $this->apiUrl . "shows/$traktId/certifications";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all translations for a show, including language and translated values for title, tagline and overview.
     *
     * https://trakt.docs.apiary.io/#reference/shows/translations
     * @param string $traktId
     * @param string $language
     * @return array
     */
    public function translations(string $traktId, string $language = 'pt'): array
    {
        $uri = $this->apiUrl . "shows/$traktId/translations/$language";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all lists that contain this show. By default, personal lists are returned sorted by the most popular.
     *
     * https://trakt.docs.apiary.io/#reference/shows/lists
     * @param string $traktId
     * @param string $type
     * @param string $sort
     * @param integer $page
     * @param integer $limit
     * @return array
     */
    public function lists(
        string $traktId,
        string $type = 'personal',
        string $sort = 'popular',
        int $page = 1,
        int $limit = 10
    ): array {
        $uri = $this->apiUrl . "shows/$traktId/lists/$type/$sort?page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns collection progress for a show including details on all aired seasons and episodes.
     *
     * https://trakt.docs.apiary.io/#reference/shows/collection-progress
     * @param string $traktId
     * @param string $hidden
     * @param string $specials
     * @param string $countSpecials
     * @return array
     */
    public function collectionProgress(
        string $traktId,
        string $hidden = 'false',
        string $specials = 'false',
        string $countSpecials = 'true'
    ): array {
        $uri = $this->apiUrl
            . "shows/$traktId/progress/collection?hidden=$hidden&specials=$specials&count_specials=$countSpecials";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns watched progress for a show including details on all aired seasons and episodes.
     *
     * https://trakt.docs.apiary.io/#reference/shows/watched-progress
     * @param string $traktId
     * @param string $hidden
     * @param string $specials
     * @param string $countSpecials
     * @return array
     */
    public function watchedProgress(
        string $traktId,
        string $hidden = 'false',
        string $specials = 'false',
        string $countSpecials = 'true'
    ): array {
        $uri = $this->apiUrl
            . "shows/$traktId/progress/watched?hidden=$hidden&specials=$specials&count_specials=$countSpecials";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all cast and crew for a show, including the episode_count for which they appear.
     * Each cast member will have a characters array and a standard person object.
     *
     * https://trakt.docs.apiary.io/#reference/shows/people
     * @param string $traktId
     * @return array
     */
    public function people(string $traktId): array
    {
        $uri = $this->apiUrl . "shows/$traktId/people?extended=full";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns rating (between 0 and 10) and distribution for a show.
     *
     * https://trakt.docs.apiary.io/#reference/shows/ratings
     * @param string $traktId
     * @return array
     */
    public function ratings(string $traktId): array
    {
        $uri = $this->apiUrl . "shows/$traktId/ratings";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns related and similar shows.
     *
     * https://trakt.docs.apiary.io/#reference/shows/related
     * @param string $traktId
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function related(string $traktId, int $page = 1, int $limit = 10): array
    {
        $uri = $this->apiUrl . "shows/$traktId/related?extended=full&page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns lots of show stats.
     *
     * https://trakt.docs.apiary.io/#reference/shows/stats
     * @param string $traktId
     * @return array
     */
    public function stats(string $traktId): array
    {
        $uri = $this->apiUrl . "shows/$traktId/stats";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all users watching this show right now.
     *
     * https://trakt.docs.apiary.io/#reference/shows/watching
     * @param string $traktId
     * @return array
     */
    public function watching(string $traktId): array
    {
        $uri = $this->apiUrl . "shows/$traktId/watching?extended=full";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the next scheduled to air episode. If no episode is found, a 204 HTTP status code will be returned.
     *
     * https://trakt.docs.apiary.io/#reference/shows/next-episode
     * @param string $traktId
     * @return array
     */
    public function nextEpisode(string $traktId): array
    {
        $uri = $this->apiUrl . "shows/$traktId/next_episode?extended=full";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most recently aired episode. If no episode is found, a 204 HTTP status code will be returned.
     *
     * https://trakt.docs.apiary.io/#reference/shows/last-episode
     * @param string $traktId
     * @return array
     */
    public function lastEpisode(string $traktId): array
    {
        $uri = $this->apiUrl . "shows/$traktId/last_episode?extended=full";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }
}
