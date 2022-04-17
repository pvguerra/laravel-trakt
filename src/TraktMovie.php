<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Support\Facades\Http;

class TraktMovie extends LaravelTrakt
{
    /**
     * Returns a single movie's details.
     *
     * https://trakt.docs.apiary.io/#reference/movies/summary/get-a-movie
     * @param string $traktId
     * @param ?string $extended
     * @return array
     */
    public function get(string $traktId, ?string $extended = null): array
    {
        $uri = $extended ? "movies/$traktId?extended=$extended" : "movies/$traktId";

        return Http::withHeaders($this->headers)->get($this->apiUrl . $uri)->json();
    }

    /**
     * Returns all movies being watched right now. Movies with the most users are returned first.
     *
     * https://trakt.docs.apiary.io/#reference/movies/trending
     * @param ?string $extended
     * @return array
     */
    public function trending(?string $extended = null): array
    {
        $uri = $extended ? "movies/trending?extended=$extended" : "movies/trending";

        return Http::withHeaders($this->headers)->get($this->apiUrl . $uri)->json();
    }

    /**
     * Returns the most popular movies.
     * Popularity is calculated using the rating percentage and the number of ratings.
     *
     * https://trakt.docs.apiary.io/#reference/movies/populae/get-a-movie
     * @param ?string $extended
     * @return array
     */
    public function popular(?string $extended = null): array
    {
        $uri = $extended ? "movies/popular?extended=$extended" : "movies/popular";

        return Http::withHeaders($this->headers)->get($this->apiUrl . $uri)->json();
    }
}
