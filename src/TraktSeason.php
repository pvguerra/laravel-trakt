<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktSeason
{
    public function __construct(protected ClientInterface $client)
    {
    }

    /**
     * Returns all seasons for a show including the seasonNumber of episodes in each season.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/summary/get-all-seasons-for-a-show
     * @param string|int $traktId
     * @return array
     */
    public function all(
        string|int $traktId,
        bool $extended = false,
        ?string $level = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        
        return $this->client->get("shows/{$traktId}/seasons", $params)->json();
    }

    /**
     * Returns Returns a single seasons for a show.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/season/get-single-season-for-a-show
     * @param string|int $traktId
     * @return array
     */
    public function info(
        string|int $traktId,
        bool $extended = false,
        ?string $level = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        
        return $this->client->get("shows/{$traktId}/seasons/info", $params)->json();
    }

    /**
     * Returns all episodes for a specific season of a show.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/episodes/get-all-episodes-for-a-single-season
     * @param string|int $traktId
     * @param int $seasonNumber
     * @return array
     */
    public function episodes(
        string|int $traktId,
        int $seasonNumber,
        bool $extended = false,
        ?string $level = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        return $this->client->get("shows/{$traktId}/seasons/$seasonNumber", $params)->json();
    }

    /**
     * Returns all cast and crew for a season, including the episode_count for which they appear.
     * Each cast member will have a characters array and a standard person object.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/people/get-all-people-for-a-season
     * @param string|int $traktId
     * @param int $seasonNumber
     * @return array
     */
    public function people(
        string|int $traktId,
        int $seasonNumber,
        bool $extended = false,
        ?string $level = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        
        return $this->client->get("shows/{$traktId}/seasons/$seasonNumber/people", $params)->json();
    }

    /**
     * Returns rating (between 0 and 10) and distribution for a season.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/ratings/get-season-ratings
     * @param string|int $traktId
     * @param int $seasonNumber
     * @return array
     */
    public function ratings(
        string|int $traktId,
        int $seasonNumber
    ): array
    {        
        return $this->client->get("shows/{$traktId}/seasons/$seasonNumber/ratings")->json();
    }

    /**
     * Returns lots of season stats.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/stats/get-season-stats
     * @param string|int $traktId
     * @param int $seasonNumber
     * @return array
     */
    public function stats(string|int $traktId, int $seasonNumber): array
    {           
        return $this->client->get("shows/{$traktId}/seasons/$seasonNumber/stats")->json();
    }

    /**
     * Returns all users watching this season right now.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/watching/get-users-watching-right-now
     * @param string|int $traktId
     * @param int $seasonNumber
     * @return array
     */
    public function watching(
        string|int $traktId,
        int $seasonNumber,
        bool $extended = false,
        ?string $level = null
    ): array
    {        
        $params = $this->client->buildExtendedParams($extended, $level);
        
        return $this->client->get("shows/{$traktId}/seasons/$seasonNumber/watching", $params)->json();
    }

    /**
     * Returns all videos for a season.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/videos/get-all-videos
     * @param string|int $traktId
     * @param int $seasonNumber
     * @return array
     */
    public function videos(
        string|int $traktId,
        int $seasonNumber,
        bool $extended = false,
        ?string $level = null
    ): array
    {        
        $params = $this->client->buildExtendedParams($extended, $level);
        
        return $this->client->get("shows/{$traktId}/seasons/$seasonNumber/videos", $params)->json();
    }
}
