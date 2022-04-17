<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Support\Facades\Http;

class TraktList extends LaravelTrakt
{
    /**
     * Returns a single list. Use the /lists/:id/items method to get the actual items this list contains.
     * Note: You must use an integer id, and only public lists will return data.
     *
     * https://trakt.docs.apiary.io/#reference/lists
     * @param int $traktId
     * @return array
     */
    public function get(int $traktId): array
    {
        $uri = $this->apiUrl . "lists/$traktId";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Get all items on a custom list. Items can be a movie, show, season, episode, or person.
     * You can optionally specify the type parameter with a single value or comma delimited string
     * for multiple item types.
     *
     * https://trakt.docs.apiary.io/#reference/lists/list-items/get-items-on-a-list
     * @param int $traktId
     * @param string $type
     * @return array
     */
    public function items(int $traktId, string $type): array
    {
        $uri = $this->apiUrl . "lists/$traktId/items/$type";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all lists with the most likes and comments over the last 7 days.
     *
     * https://trakt.docs.apiary.io/#reference/lists
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function trending(int $page = 1, int $limit = 10): array
    {
        $uri = $this->apiUrl . "lists/trending?page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most popular lists. Popularity is calculated using total number of likes and comments.
     *
     * https://trakt.docs.apiary.io/#reference/lists
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function popular(int $page = 1, int $limit = 10): array
    {
        $uri = $this->apiUrl . "lists/popular?page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }
}