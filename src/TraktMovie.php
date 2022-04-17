<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Support\Facades\Http;

class TraktMovie extends LaravelTrakt
{
    /**
     * Returns a single movie's details.
     *
     * https://trakt.docs.apiary.io/#reference/movies/summary
     * @param string $traktId
     * @return array
     */
    public function get(string $traktId): array
    {
        $uri = $this->apiUrl . "movies/$traktId?extended=full";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all movies being watched right now. Movies with the most users are returned first.
     *
     * https://trakt.docs.apiary.io/#reference/movies/trending
     * @param ?string $filters
     * @return array
     */
    public function trending(?string $filters = null): array
    {
        $uri = $this->apiUrl . "movies/trending?extended=full" . ($filters ? "&$filters" : "");

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most popular movies.
     * Popularity is calculated using the rating percentage and the number of ratings.
     *
     * https://trakt.docs.apiary.io/#reference/movies/popular
     * @param ?string $filters
     * @return array
     */
    public function popular(?string $filters = null): array
    {
        $uri = $this->apiUrl . "movies/popular?extended=full" . ($filters ? "&$filters" : "");

        return Http::withHeaders($this->headers)->get($uri)->json();
    }
}
