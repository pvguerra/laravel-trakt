<?php

namespace Pvguerra\LaravelTrakt;

use Exception;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktShow
{
    public function __construct(protected ClientInterface $client)
    {
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
    public function trending(
        int $page = 1,
        int $limit = 10,
        bool $extended = false,
        ?string $level = 'full',
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("shows/trending", $params)->json();
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
    public function popular(
        int $page = 1,
        int $limit = 10,
        bool $extended = false,
        ?string $level = 'full',
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("shows/popular", $params)->json();
    }

    /**
     * Returns the most favorited shows in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/shows/favorited
     * @param string $period
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function favorited(
        int $page = 1,
        int $limit = 10,
        string $period = 'weekly',
        bool $extended = false,
        ?string $level = 'full',
        ?string $filters = null
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("shows/favorited/{$period}", $params)->json();
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
        int $page = 1,
        int $limit = 10,
        string $period = 'weekly',
        bool $extended = false,
        ?string $level = 'full',
        ?string $filters = null
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("shows/played/{$period}", $params)->json();
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
        int $page = 1,
        int $limit = 10,
        string $period = 'weekly',
        bool $extended = false,
        ?string $level = 'full',
        ?string $filters = null
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("shows/watched/{$period}", $params)->json();
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
        int $page = 1,
        int $limit = 10,
        string $period = 'weekly',
        bool $extended = false,
        ?string $level = 'full',
        ?string $filters = null
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("shows/collected/{$period}", $params)->json();
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
    public function anticipated(
        int $page = 1,
        int $limit = 10,
        bool $extended = false,
        ?string $level = 'full',
        ?string $filters = null
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));
        $params = $this->client->addFiltersToParams($params, $filters);
        
        return $this->client->get("shows/anticipated", $params)->json();
    }

    /**
     * Returns a single show's details.
     * If you request extended info, the airs object is relative to the show's country.
     * You can use the day, time, and timezone to construct your own date then convert it
     * to whatever timezone your user is in.
     *
     * https://trakt.docs.apiary.io/#reference/shows/summary
     * @param string|int $traktId
     * @return array
     */
    public function get(
        string|int $traktId,
        bool $extended = false,
        ?string $level = 'full'
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        return $this->client->get("shows/{$traktId}", $params)->json();
    }

    /**
     * Returns all title aliases for a show. Includes country where name is different.
     *
     * https://trakt.docs.apiary.io/#reference/shows/aliases
     * @param string|int $traktId
     * @return array
     */
    public function aliases(string|int $traktId): array
    {
        return $this->client->get("shows/{$traktId}/aliases", [])->json();
    }

    /**
     * Returns all content certifications for a show, including the country.
     *
     * https://trakt.docs.apiary.io/#reference/shows/certifications
     * @param string|int $traktId
     * @return array
     */
    public function certifications(
        string|int $traktId,
    ): array
    {
        return $this->client->get("shows/{$traktId}/certifications", [])->json();
    }

    /**
     * Returns all translations for a show, including language and translated values for title, tagline and overview.
     *
     * https://trakt.docs.apiary.io/#reference/shows/translations
     * @param string|int $traktId
     * @param string $language
     * @return array
     */
    public function translations(
        string|int $traktId,
        string $language = 'pt',
    ): array
    {
        return $this->client->get("shows/{$traktId}/translations/{$language}", [])->json();
    }

    /**
     * Returns all lists that contain this show. By default, personal lists are returned sorted by the most popular.
     *
     * https://trakt.docs.apiary.io/#reference/shows/lists
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
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);

        $queryString = $this->client->buildQueryString($params);
        return $this->client->get("shows/{$traktId}/lists/{$type}/{$sort}{$queryString}")->json();
    }

    /**
     * Returns collection progress for a show including details on all aired seasons and episodes.
     *
     * https://trakt.docs.apiary.io/#reference/shows/collection-progress
     * @param string|int $traktId
     * @param string $hidden
     * @param string $specials
     * @param string $countSpecials
     * @return array
     */
    public function collectionProgress(
        string|int $traktId,
        string $hidden = 'false',
        string $specials = 'false',
        string $countSpecials = 'true'
    ): array {
        $queryString = $this->client->buildQueryString([
            'hidden' => $hidden,
            'specials' => $specials,
            'count_specials' => $countSpecials,
        ]);
        return $this->client->get("shows/{$traktId}/progress/collection{$queryString}")->json();
    }

    /**
     * Returns watched progress for a show including details on all aired seasons and episodes.
     *
     * https://trakt.docs.apiary.io/#reference/shows/watched-progress
     * @param string|int $traktId
     * @param string $hidden
     * @param string $specials
     * @param string $countSpecials
     * @return array
     */
    public function watchedProgress(
        string|int $traktId,
        string $hidden = 'false',
        string $specials = 'false',
        string $countSpecials = 'true'
    ): array {
        $queryString = $this->client->buildQueryString([
            'hidden' => $hidden,
            'specials' => $specials,
            'count_specials' => $countSpecials,
        ]);
        return $this->client->get("shows/{$traktId}/progress/watched{$queryString}")->json();
    }

    /**
     * Returns all cast and crew for a show, including the episode_count for which they appear.
     * Each cast member will have a characters array and a standard person object.
     *
     * https://trakt.docs.apiary.io/#reference/shows/people
     * @param string|int $traktId
     * @param bool $extended
     * @param string|null $level
     * @return array
     */
    public function people(
        string|int $traktId,
        bool $extended = false,
        ?string $level = 'full'
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        return $this->client->get("shows/{$traktId}/people", $params)->json();
    }

    /**
     * Returns rating (between 0 and 10) and distribution for a show.
     *
     * https://trakt.docs.apiary.io/#reference/shows/ratings
     * @param string|int $traktId
     * @return array
     */
    public function ratings(string|int $traktId): array
    {
        return $this->client->get("shows/{$traktId}/ratings", [])->json();
    }

    /**
     * Returns related and similar shows.
     *
     * https://trakt.docs.apiary.io/#reference/shows/related
     * @param string|int $traktId
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function related(
        string|int $traktId,
        int $page = 1,
        int $limit = 10,
        bool $extended = false,
        ?string $level = 'full'
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));
        
        return $this->client->get("shows/{$traktId}/related", $params)->json();
    }

    /**
     * Returns lots of show stats.
     *
     * https://trakt.docs.apiary.io/#reference/shows/stats
     * @param string|int $traktId
     * @return array
     */
    public function stats(string|int $traktId): array
    {
        return $this->client->get("shows/{$traktId}/stats", [])->json();
    }

    /**
     * Returns all users watching this show right now.
     *
     * https://trakt.docs.apiary.io/#reference/shows/watching
     * @param string|int $traktId
     * @return array
     */
    public function watching(
        string|int $traktId,
        bool $extended = false,
        ?string $level = 'full'
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        
        return $this->client->get("shows/{$traktId}/watching", $params)->json();
    }

    /**
     * Returns the next scheduled to air episode. If no episode is found, a 204 HTTP status code will be returned.
     *
     * https://trakt.docs.apiary.io/#reference/shows/next-episode
     * @param string|int $traktId
     * @return array
     */
    public function nextEpisode(
        string|int $traktId,
        bool $extended = false,
        ?string $level = 'full'
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        
        return $this->client->get("shows/{$traktId}/next_episode", $params)->json();
    }

    /**
     * Returns the most recently aired episode. If no episode is found, a 204 HTTP status code will be returned.
     *
     * https://trakt.docs.apiary.io/#reference/shows/last-episode
     * @param string|int $traktId
     * @return array
     */
    public function lastEpisode(
        string|int $traktId,
        bool $extended = false,
        ?string $level = 'full'
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        
        return $this->client->get("shows/{$traktId}/last_episode", $params)->json();
    }

    /**
     * Returns all videos including trailers, teasers, clips, and featurettes.
     *
     * https://trakt.docs.apiary.io/#reference/shows/videos/get-all-videos
     * @param string|int $traktId
     * @return array
     */
    public function videos(
        string|int $traktId,
        bool $extended = false,
        ?string $level = 'full'
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        
        return $this->client->get("shows/{$traktId}/videos", $params)->json();
    }
}
