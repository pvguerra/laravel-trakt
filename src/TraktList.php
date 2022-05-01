<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktList extends LaravelTrakt
{
    use HttpResponses;

    /**
     * Returns a single list. Use the /lists/:id/items method to get the actual items this list contains.
     * Note: You must use an integer id, and only public lists will return data.
     *
     * https://trakt.docs.apiary.io/#reference/lists
     * @param int $traktId
     * @return JsonResponse
     */
    public function get(int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "lists/$traktId";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Get all items on a custom list. Items can be a movie, show, season, episode, or person.
     * You can optionally specify the type parameter with a single value or comma delimited string
     * for multiple item types.
     *
     * https://trakt.docs.apiary.io/#reference/lists/list-items/get-items-on-a-list
     * @param int $traktId
     * @param string $type
     * @return JsonResponse
     */
    public function items(int $traktId, string $type): JsonResponse
    {
        $uri = $this->apiUrl . "lists/$traktId/items/$type";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all lists with the most likes and comments over the last 7 days.
     *
     * https://trakt.docs.apiary.io/#reference/lists
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function trending(int $page = 1, int $limit = 10): JsonResponse
    {
        $uri = $this->apiUrl . "lists/trending?page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most popular lists. Popularity is calculated using total number of likes and comments.
     *
     * https://trakt.docs.apiary.io/#reference/lists
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function popular(int $page = 1, int $limit = 10): JsonResponse
    {
        $uri = $this->apiUrl . "lists/popular?page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }
}
