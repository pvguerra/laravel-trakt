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
     * Returns all title aliases for a movie. Includes country where name is different.
     *
     * https://trakt.docs.apiary.io/#reference/movies/aliases
     * @param string $traktId
     * @return array
     */
    public function aliases(string $traktId): array
    {
        $uri = $this->apiUrl . "movies/$traktId/aliases";

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

    /**
     * Returns the most recommended movies in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/movies/recommended
     * @param string $period
     * @param ?string $filters
     * @return array
     */
    public function recommended(string $period = 'weekly', ?string $filters = null): array
    {
        $uri = $this->apiUrl . "movies/recommended/$period?extended=full" . ($filters ? "&$filters" : "");

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most played (a single user can watch multiple times) movies in the specified time period,
     * defaulting to weekly. All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/movies/played
     * @param string $period
     * @param ?string $filters
     * @return array
     */
    public function played(string $period = 'weekly', ?string $filters = null): array
    {
        $uri = $this->apiUrl . "movies/played/$period?extended=full" . ($filters ? "&$filters" : "");

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most watched (unique users) movies in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/movies/watched
     * @param string $period
     * @param ?string $filters
     * @return array
     */
    public function watched(string $period = 'weekly', ?string $filters = null): array
    {
        $uri = $this->apiUrl . "movies/watched/$period?extended=full" . ($filters ? "&$filters" : "");

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most collected (unique users) movies in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/movies/collected
     * @param string $period
     * @param ?string $filters
     * @return array
     */
    public function collected(string $period = 'weekly', ?string $filters = null): array
    {
        $uri = $this->apiUrl . "movies/collected/$period?extended=full" . ($filters ? "&$filters" : "");

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the most anticipated movies based on the number of lists a movie appears on.
     *
     * https://trakt.docs.apiary.io/#reference/movies/anticipated
     * @param ?string $filters
     * @return array
     */
    public function anticipated(?string $filters = null): array
    {
        $uri = $this->apiUrl . "movies/anticipated?extended=full" . ($filters ? "&$filters" : "");

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns the top 10 grossing movies in the U.S. box office last weekend. Updated every Monday morning.
     *
     * https://trakt.docs.apiary.io/#reference/movies/boxoffice
     * @return array
     */
    public function boxOffice(): array
    {
        $uri = $this->apiUrl . "movies/boxoffice?extended=full";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all releases for a movie including country, certification, release date, release type, and note.
     * The release type can be set to unknown, premiere, limited, theatrical, digital, physical, or tv.
     * The note might have optional info such as the film festival name for a premiere release or Blu-ray specs
     * for a physical release. We pull this info from TMDB.
     *
     * https://trakt.docs.apiary.io/#reference/movies/releases
     * @param string $traktId
     * @param string $country
     * @return array
     */
    public function releases(string $traktId, string $country = 'us'): array
    {
        $uri = $this->apiUrl . "movies/$traktId/releases/$country";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }

    /**
     * Returns all translations for a movie, including language and translated values for title, tagline and overview.
     *
     * https://trakt.docs.apiary.io/#reference/movies/translations
     * @param string $traktId
     * @param string $language
     * @return array
     */
    public function translations(string $traktId, string $language = 'pt'): array
    {
        $uri = $this->apiUrl . "movies/$traktId/translations/$language";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }
}
