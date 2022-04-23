<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktPerson extends LaravelTrakt
{
    use HttpResponses;

    /**
     * Returns a single person's details.
     *
     * https://trakt.docs.apiary.io/#reference/people/summary
     * @param string $traktId
     * @return JsonResponse
     */
    public function get(string $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "people/$traktId?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all movies where this person is in the cast or crew.
     * Each cast object will have a characters array and a standard movie object.
     *
     * https://trakt.docs.apiary.io/#reference/people/summary/get-movie-credits
     * @param string $traktId
     * @return JsonResponse
     */
    public function getMovieCredits(string $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "people/$traktId/movies?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all shows where this person is in the cast or crew, including the episode_count for which they appear.
     * Each cast object will have a characters array and a standard show object.
     * If series_regular is true, this person is a series regular and not simply a guest star.
     *
     * https://trakt.docs.apiary.io/#reference/people/summary/get-show-credits
     * @param string $traktId
     * @return JsonResponse
     */
    public function getShowCredits(string $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "people/$traktId/shows?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all lists that contain this person. By default, personal lists are returned sorted by the most popular.
     *
     * https://trakt.docs.apiary.io/#reference/people/summary/get-lists-containing-this-person
     * @param string $traktId
     * @param string $type
     * @param string $sort
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function lists(
        string $traktId,
        string $type = 'personal',
        string $sort = 'popular',
        int $page = 1,
        int $limit = 10
    ): JsonResponse {
        $uri = $this->apiUrl . "people/$traktId/lists/$type/$sort?page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }
}