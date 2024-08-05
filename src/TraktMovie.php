<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktMovie extends LaravelTrakt
{
    use HttpResponses;

    /**
     * Returns a single movie's details.
     *
     * https://trakt.docs.apiary.io/#reference/movies/summary
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function get(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "movies/$traktId?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all title aliases for a movie. Includes country where name is different.
     *
     * https://trakt.docs.apiary.io/#reference/movies/aliases
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function aliases(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "movies/$traktId/aliases";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all movies being watched right now. Movies with the most users are returned first.
     *
     * https://trakt.docs.apiary.io/#reference/movies/trending
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function trending(?string $filters = null, int $page = 1, int $limit = 10): JsonResponse
    {
        $uri = $this->apiUrl
            . "movies/trending?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most popular movies.
     * Popularity is calculated using the rating percentage and the number of ratings.
     *
     * https://trakt.docs.apiary.io/#reference/movies/popular
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function popular(?string $filters = null, int $page = 1, int $limit = 10): JsonResponse
    {
        $uri = $this->apiUrl
            . "movies/popular?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most recommended movies in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/movies/recommended
     * @param string $period
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function recommended(
        string $period = 'weekly',
        ?string $filters = null,
        int $page = 1,
        int $limit = 10
    ): JsonResponse {
        $uri = $this->apiUrl
            . "movies/recommended/$period?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most played (a single user can watch multiple times) movies in the specified time period,
     * defaulting to weekly. All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/movies/played
     * @param string $period
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function played(
        string $period = 'weekly',
        ?string $filters = null,
        int $page = 1,
        int $limit = 10
    ): JsonResponse {
        $uri = $this->apiUrl
            . "movies/played/$period?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most watched (unique users) movies in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/movies/watched
     * @param string $period
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function watched(
        string $period = 'weekly',
        ?string $filters = null,
        int $page = 1,
        int $limit = 10
    ): JsonResponse {
        $uri = $this->apiUrl
            . "movies/watched/$period?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most collected (unique users) movies in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/movies/collected
     * @param string $period
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function collected(
        string $period = 'weekly',
        ?string $filters = null,
        int $page = 1,
        int $limit = 10
    ): JsonResponse {
        $uri = $this->apiUrl
            . "movies/collected/$period?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most anticipated movies based on the number of lists a movie appears on.
     *
     * https://trakt.docs.apiary.io/#reference/movies/anticipated
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function anticipated(?string $filters = null, int $page = 1, int $limit = 10): JsonResponse
    {
        $uri = $this->apiUrl
            . "movies/anticipated?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        return response()->json(Http::withHeaders($this->headers)->get($uri));
    }

    /**
     * Returns the top 10 grossing movies in the U.S. box office last weekend. Updated every Monday morning.
     *
     * https://trakt.docs.apiary.io/#reference/movies/boxoffice
     * @return JsonResponse
     */
    public function boxOffice(): JsonResponse
    {
        $uri = $this->apiUrl . "movies/boxoffice?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all releases for a movie including country, certification, release date, release type, and note.
     * The release type can be set to unknown, premiere, limited, theatrical, digital, physical, or tv.
     * The note might have optional info such as the film festival name for a premiere release or Blu-ray specs
     * for a physical release. We pull this info from TMDB.
     *
     * https://trakt.docs.apiary.io/#reference/movies/releases
     * @param string|int $traktId
     * @param string $country
     * @return JsonResponse
     */
    public function releases(string|int $traktId, string $country = 'us'): JsonResponse
    {
        $uri = $this->apiUrl . "movies/$traktId/releases/$country";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all translations for a movie, including language and translated values for title, tagline and overview.
     *
     * https://trakt.docs.apiary.io/#reference/movies/translations
     * @param string|int $traktId
     * @param string $language
     * @return JsonResponse
     */
    public function translations(string|int $traktId, string $language = 'pt'): JsonResponse
    {
        $uri = $this->apiUrl . "movies/$traktId/translations/$language";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all lists that contain this movie. By default, personal lists are returned sorted by the most popular.
     *
     * https://trakt.docs.apiary.io/#reference/movies/lists
     * @param string|int $traktId
     * @param string $type
     * @param string $sort
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function lists(
        string|int $traktId,
        string $type = 'personal',
        string $sort = 'popular',
        int $page = 1,
        int $limit = 10
    ): JsonResponse {
        $uri = $this->apiUrl . "movies/$traktId/lists/$type/$sort?page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all cast and crew for a movie.
     * Each cast member will have a characters array and a standard person object.
     * The crew object will be broken up by department into production, art, crew, costume & make-up,
     * directing, writing, sound, camera, visual effects, lighting, and editing (if there are people
     * for those crew positions). Each of those members will have a jobs array and a standard person object.
     *
     * https://trakt.docs.apiary.io/#reference/movies/people
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function people(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "movies/$traktId/people?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns rating (between 0 and 10) and distribution for a movie.
     *
     * https://trakt.docs.apiary.io/#reference/movies/ratings
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function ratings(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "movies/$traktId/ratings";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns related and similar movies.
     *
     * https://trakt.docs.apiary.io/#reference/movies/related
     * @param string|int $traktId
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function related(string|int $traktId, int $page = 1, int $limit = 10): JsonResponse
    {
        $uri = $this->apiUrl . "movies/$traktId/related?extended=full&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns lots of movie stats.
     *
     * https://trakt.docs.apiary.io/#reference/movies/stats
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function stats(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "movies/$traktId/stats";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all users watching this movie right now.
     *
     * https://trakt.docs.apiary.io/#reference/movies/watching
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function watching(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "movies/$traktId/watching?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }
}
