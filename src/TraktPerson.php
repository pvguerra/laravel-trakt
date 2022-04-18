<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Support\Facades\Http;

class TraktPerson extends LaravelTrakt
{
    /**
     * Returns a single person's details.
     *
     * https://trakt.docs.apiary.io/#reference/people/summary
     * @param string $traktId
     * @return array
     */
    public function get(string $traktId): array
    {
        $uri = $this->apiUrl . "people/$traktId?extended=full";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all movies where this person is in the cast or crew.
     * Each cast object will have a characters array and a standard movie object.
     *
     * https://trakt.docs.apiary.io/#reference/people/summary/get-movie-credits
     * @param string $traktId
     * @return array
     */
    public function getMovieCredits(string $traktId): array
    {
        $uri = $this->apiUrl . "people/$traktId/movies?extended=full";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all shows where this person is in the cast or crew, including the episode_count for which they appear.
     * Each cast object will have a characters array and a standard show object.
     * If series_regular is true, this person is a series regular and not simply a guest star.
     *
     * https://trakt.docs.apiary.io/#reference/people/summary/get-show-credits
     * @param string $traktId
     * @return array
     */
    public function getShowCredits(string $traktId): array
    {
        $uri = $this->apiUrl . "people/$traktId/shows?extended=full";

        return Http::withHeaders($this->headers)->get($uri)->json();
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
     * @return array
     */
    public function lists(
        string $traktId,
        string $type = 'personal',
        string $sort = 'popular',
        int $page = 1,
        int $limit = 10
    ): array {
        $uri = $this->apiUrl . "people/$traktId/lists/$type/$sort?page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }
}