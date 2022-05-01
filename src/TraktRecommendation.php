<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktRecommendation extends LaravelTrakt
{
    use HttpResponses;

    /**
     * Movie recommendations for a user. By default, 10 results are returned. You can send a limit to get up to
     * 100 results per page.
     * Set ?ignore_collected=true to filter out movies the user has already collected.
     *
     * https://trakt.docs.apiary.io/#reference/recommendations/movies/get-movie-recommendations
     * @param int $page
     * @param int $limit
     * @param string $ignoreCollected
     * @return JsonResponse
     */
    public function getMovies(int $page = 1, int $limit = 10, string $ignoreCollected = 'false'): JsonResponse
    {
        $uri = $this->apiUrl . "recommendations/movies?page=$page&limit=$limit&ignore_collected=$ignoreCollected";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Hide a movie from getting recommended anymore.
     *
     * https://trakt.docs.apiary.io/#reference/recommendations/movies/hide-a-movie-recommendation
     * @param string $traktId
     * @return JsonResponse
     */
    public function hideMovie(string $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "recommendations/movies/$traktId";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
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
     * @return JsonResponse
     */
    public function getShows(int $page = 1, int $limit = 10, string $ignoreCollected = 'false'): JsonResponse
    {
        $uri = $this->apiUrl . "recommendations/shows?page=$page&limit=$limit&ignore_collected=$ignoreCollected";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Hide a show from getting recommended anymore.
     *
     * https://trakt.docs.apiary.io/#reference/recommendations/shows/hide-a-show-recommendation
     * @param string $traktId
     * @return JsonResponse
     */
    public function hideShow(string $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "recommendations/shows/$traktId";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }
}
