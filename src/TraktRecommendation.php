<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktRecommendation
{
    public function __construct(protected ClientInterface $client)
    {
    }

    /**
     * Movie recommendations for a user. By default, 10 results are returned. You can send a limit to get up to
     * 100 results per page.
     * Set ?ignore_collected=true to filter out movies the user has already collected.
     *
     * https://trakt.docs.apiary.io/#reference/recommendations/movies/get-movie-recommendations
     * @param int $page
     * @param int $limit
     * @param bool $ignoreCollected
     * @return array
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function getMovies(
        int $page = 1,
        int $limit = 10,
        bool $ignoreCollected = false
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params['ignore_collected'] = $ignoreCollected ? 'true' : 'false';
        
        return $this->client->get("recommendations/movies", $params)->json();
    }

    /**
     * Hide a movie from getting recommended anymore.
     *
     * https://trakt.docs.apiary.io/#reference/recommendations/movies/hide-a-movie-recommendation
     * @param string $traktId
     * @return array
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function hideMovie(string $traktId): array
    {
        return $this->client->delete("recommendations/movies/{$traktId}")->json();
    }

    /**
     * TV show recommendations for a user. By default, 10 results are returned.
     * You can send a limit to get up to 100 results per page.
     * Set ?ignore_collected=true to filter out shows the user has already collected.
     *
     * https://trakt.docs.apiary.io/#reference/recommendations/shows/get-show-recommendations
     * @param int $page
     * @param int $limit
     * @param bool $ignoreCollected
     * @return array
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function getShows(
        int $page = 1,
        int $limit = 10,
        bool $ignoreCollected = false
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params['ignore_collected'] = $ignoreCollected ? 'true' : 'false';
        
        return $this->client->get("recommendations/shows", $params)->json();
    }

    /**
     * Hide a show from getting recommended anymore.
     *
     * https://trakt.docs.apiary.io/#reference/recommendations/shows/hide-a-show-recommendation
     * @param string $traktId
     * @return array
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Exception
     */
    public function hideShow(string $traktId): array
    {
        return $this->client->delete("recommendations/shows/{$traktId}")->json();
    }
}
