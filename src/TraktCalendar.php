<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktCalendar extends LaravelTrakt
{
    use HttpResponses;

    /**
     * Returns all shows airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-shows/get-shows
     * @param string $startDate
     * @param int $days
     * @return JsonResponse
     */
    public function shows(string $startDate, int $days): JsonResponse
    {
        $uri = $this->apiUrl . "calendars/my/shows/$startDate/$days?extended=full";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all new show premieres (season 1, episode 1) airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-shows/get-new-shows
     * @param string $startDate
     * @param int $days
     * @return JsonResponse
     */
    public function newShows(string $startDate, int $days): JsonResponse
    {
        $uri = $this->apiUrl . "calendars/my/shows/new/$startDate/$days?extended=full";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all show premieres (any season, episode 1) airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-season-premieres/get-season-premieres
     * @param string $startDate
     * @param int $days
     * @return JsonResponse
     */
    public function seasonPremieres(string $startDate, int $days): JsonResponse
    {
        $uri = $this->apiUrl . "calendars/my/shows/premieres/$startDate/$days?extended=full";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all movies with a release date during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-movies/get-movies
     * @param string $startDate
     * @param int $days
     * @return JsonResponse
     */
    public function movies(string $startDate, int $days): JsonResponse
    {
        $uri = $this->apiUrl . "calendars/my/movies/$startDate/$days?extended=full";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all shows airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/all-shows/get-shows
     * @param string $startDate
     * @param int $days
     * @return JsonResponse
     */
    public function allShows(string $startDate, int $days): JsonResponse
    {
        $uri = $this->apiUrl . "calendars/all/shows/$startDate/$days?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all new show premieres (season 1, episode 1) airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-shows/get-new-shows
     * @param string $startDate
     * @param int $days
     * @return JsonResponse
     */
    public function allNewShows(string $startDate, int $days): JsonResponse
    {
        $uri = $this->apiUrl . "calendars/all/shows/new/$startDate/$days?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all show premieres (any season, episode 1) airing during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/all-season-premieres/get-season-premieres
     * @param string $startDate
     * @param int $days
     * @return JsonResponse
     */
    public function allSeasonPremieres(string $startDate, int $days): JsonResponse
    {
        $uri = $this->apiUrl . "calendars/all/shows/premieres/$startDate/$days?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all movies with a release date during the time period specified.
     *
     * https://trakt.docs.apiary.io/#reference/calendars/my-movies/get-movies
     * @param string $startDate
     * @param int $days
     * @return JsonResponse
     */
    public function allMovies(string $startDate, int $days): JsonResponse
    {
        $uri = $this->apiUrl . "calendars/all/movies/$startDate/$days?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }
}
