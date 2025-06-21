<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktEpisode
{
    public function __construct(protected ClientInterface $client)
    {
    }

    /**
     * Returns a single episode's details. All date and times are in UTC and were calculated using
     * the episode's air_date and show's country and air_time.
     * Note: If the first_aired is unknown, it will be set to null.
     *
     * https://trakt.docs.apiary.io/#reference/episodes/summary/get-a-single-episode-for-a-show
     * @param string|int $traktId
     * @param int $seasonNumber
     * @param int $episodeNumber
     * @return array
     */
    public function get(
        string|int $traktId,
        int $seasonNumber,
        int $episodeNumber,
        bool $extended = false,
        ?string $level = 'full'
    ): array {
        $params = $this->client->buildExtendedParams($extended, $level);
        
        return $this->client->get("shows/{$traktId}/seasons/$seasonNumber/episodes/$episodeNumber", $params)->json();
    }

    /**
     * Returns all cast and crew for an episode.
     * Each cast member will have a characters array and a standard person object.
     *
     * https://trakt.docs.apiary.io/#reference/episodes/people/get-all-people-for-an-episode
     * @param string|int $traktId
     * @param int $seasonNumber
     * @param int $episodeNumber
     * @return array
     */
    public function people(
        string|int $traktId,
        int $seasonNumber,
        int $episodeNumber,
        bool $extended = false,
        ?string $level = 'full'
    ): array {
        $params = $this->client->buildExtendedParams($extended, $level);
        
        return $this->client->get("shows/{$traktId}/seasons/$seasonNumber/episodes/$episodeNumber/people", $params)->json();
    }

    /**
     * Returns rating (between 0 and 10) and distribution for an episode.
     *
     * https://trakt.docs.apiary.io/#reference/episodes/ratings/get-episode-ratings
     * @param string|int $traktId
     * @param int $seasonNumber
     * @param int $episodeNumber
     * @return array
     */
    public function ratings(string|int $traktId, int $seasonNumber, int $episodeNumber): array
    {        
        return $this->client->get("shows/{$traktId}/seasons/$seasonNumber/episodes/$episodeNumber/ratings")->json();
    }

    /**
     * Returns lots of episode stats.
     *
     * https://trakt.docs.apiary.io/#reference/episodes/stats/get-episode-stats
     * @param string|int $traktId
     * @param int $seasonNumber
     * @param int $episodeNumber
     * @return array
     */
    public function stats(string|int $traktId, int $seasonNumber, int $episodeNumber): array
    {        
        return $this->client->get("shows/{$traktId}/seasons/$seasonNumber/episodes/$episodeNumber/stats")->json();
    }

    /**
     * Returns all users watching this episode right now.
     *
     * https://trakt.docs.apiary.io/#reference/episodes/watching/get-users-watching-right-now
     * @param string|int $traktId
     * @param int $seasonNumber
     * @param int $episodeNumber
     * @return array
     */
    public function watching(
        string|int $traktId,
        int $seasonNumber,
        int $episodeNumber,
        bool $extended = false,
        ?string $level = 'full'
    ): array
    {        
        $params = $this->client->buildExtendedParams($extended, $level);
        
        return $this->client->get("shows/{$traktId}/seasons/$seasonNumber/episodes/$episodeNumber/watching", $params)->json();
    }
}
