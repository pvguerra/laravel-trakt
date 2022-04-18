<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Support\Facades\Http;

class TraktRecommendation extends LaravelTrakt
{
    /**
     * Movie recommendations for a user. By default, 10 results are returned. You can send a limit to get up to
     * 100 results per page.
     * Set ?ignore_collected=true to filter out movies the user has already collected.
     *
     * https://trakt.docs.apiary.io/#reference/recommendations/movies/get-movie-recommendations
     * @param int $page
     * @param int $limit
     * @param string $ignoreCollected
     * @return array
     */
    public function getMovies(int $page = 1, int $limit = 10, string $ignoreCollected = 'false'): array
    {
        $uri = $this->apiUrl . "recommendations/movies?page=$page&limit=$limit&ignore_collected=$ignoreCollected";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }

    /**
     * Hide a movie from getting recommended anymore.
     *
     * https://trakt.docs.apiary.io/#reference/recommendations/movies/hide-a-movie-recommendation
     * @param string $traktId
     * @return array
     */
    public function hideMovie(string $traktId): array
    {
        $uri = $this->apiUrl . "recommendations/movies/$traktId";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }

    /**
     * TV show recommendations for a user. By default, 10 results are returned.
     * You can send a limit to get up to 100 results per page.
     * Set ?ignore_collected=true to filter out shows the user has already collected.
     *
     * https://trakt.docs.apiary.io/#reference/recommendations/shows/get-show-recommendations
     * @param int $page
     * @param int $limit
     * @param string $ignoreCollected
     * @return array
     */
    public function getShows(int $page = 1, int $limit = 10, string $ignoreCollected = 'false'): array
    {
        $uri = $this->apiUrl . "recommendations/shows?page=$page&limit=$limit&ignore_collected=$ignoreCollected";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }

    /**
     * Hide a show from getting recommended anymore.
     *
     * https://trakt.docs.apiary.io/#reference/recommendations/shows/hide-a-show-recommendation
     * @param string $traktId
     * @return array
     */
    public function hideShow(string $traktId): array
    {
        $uri = $this->apiUrl . "recommendations/shows/$traktId";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }
}