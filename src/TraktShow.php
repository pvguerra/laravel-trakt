<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktShow extends LaravelTrakt
{
    use HttpResponses;

    /**
     * Returns a single show's details.
     * If you request extended info, the airs object is relative to the show's country.
     * You can use the day, time, and timezone to construct your own date then convert it
     * to whatever timezone your user is in.
     *
     * https://trakt.docs.apiary.io/#reference/shows/summary
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function get(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns a single show's details based on the site and id.
     * The ID can be a Trakt, IMDB, TMDB, or TVDB ID.
     *
     * https://trakt.docs.apiary.io/#reference/search/id-lookup
     * @param int $id
     * @param string $site
     * @return JsonResponse
     */
    // Get show by ID, can also be used to get a show by its TVDB, IMDB or TMDB ID.
    public function getBySiteId(int $id, string $site): JsonResponse
    {
        $site = strtolower($site);
        $uri = $this->apiUrl . "search/$site/$id?type=show&extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all title aliases for a show. Includes country where name is different.
     *
     * https://trakt.docs.apiary.io/#reference/shows/aliases
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function aliases(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/aliases";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all shows being watched right now. Shows with the most users are returned first.
     *
     * https://trakt.docs.apiary.io/#reference/shows/trending
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function trending(?string $filters = null, int $page = 1, int $limit = 10): JsonResponse
    {
        $uri = $this->apiUrl
            . "shows/trending?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most popular shows.
     * Popularity is calculated using the rating percentage and the number of ratings.
     *
     * https://trakt.docs.apiary.io/#reference/shows/popular
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function popular(?string $filters = null, int $page = 1, int $limit = 10): JsonResponse
    {
        $uri = $this->apiUrl
            . "shows/popular?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most recommended shows in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/shows/recommended
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
            . "shows/recommended/$period?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most played (a single user can watch multiple times) shows in the specified time period,
     * defaulting to weekly. All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/shows/played
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
            . "shows/played/$period?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most watched (unique users) shows in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/shows/watched
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
            . "shows/watched/$period?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most collected (unique users) shows in the specified time period, defaulting to weekly.
     * All stats are relative to the specific time period.
     *
     * https://trakt.docs.apiary.io/#reference/shows/collected
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
            . "shows/collected/$period?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most anticipated shows based on the number of lists a show appears on.
     *
     * https://trakt.docs.apiary.io/#reference/shows/anticipated
     * @param ?string $filters
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function anticipated(?string $filters = null, int $page = 1, int $limit = 10): JsonResponse
    {
        $uri = $this->apiUrl
            . "shows/anticipated?extended=full"
            . ($filters ? "&$filters" : "")
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all content certifications for a show, including the country.
     *
     * https://trakt.docs.apiary.io/#reference/shows/certifications
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function certifications(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/certifications";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all translations for a show, including language and translated values for title, tagline and overview.
     *
     * https://trakt.docs.apiary.io/#reference/shows/translations
     * @param string|int $traktId
     * @param string $language
     * @return JsonResponse
     */
    public function translations(string|int $traktId, string $language = 'pt'): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/translations/$language";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all lists that contain this show. By default, personal lists are returned sorted by the most popular.
     *
     * https://trakt.docs.apiary.io/#reference/shows/lists
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
        $uri = $this->apiUrl . "shows/$traktId/lists/$type/$sort?page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns collection progress for a show including details on all aired seasons and episodes.
     *
     * https://trakt.docs.apiary.io/#reference/shows/collection-progress
     * @param string|int $traktId
     * @param string $hidden
     * @param string $specials
     * @param string $countSpecials
     * @return JsonResponse
     */
    public function collectionProgress(
        string|int $traktId,
        string $hidden = 'false',
        string $specials = 'false',
        string $countSpecials = 'true'
    ): JsonResponse {
        $uri = $this->apiUrl
            . "shows/$traktId/progress/collection?hidden=$hidden&specials=$specials&count_specials=$countSpecials";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns watched progress for a show including details on all aired seasons and episodes.
     *
     * https://trakt.docs.apiary.io/#reference/shows/watched-progress
     * @param string|int $traktId
     * @param string $hidden
     * @param string $specials
     * @param string $countSpecials
     * @return JsonResponse
     */
    public function watchedProgress(
        string|int $traktId,
        string $hidden = 'false',
        string $specials = 'false',
        string $countSpecials = 'true'
    ): JsonResponse {
        $uri = $this->apiUrl
            . "shows/$traktId/progress/watched?hidden=$hidden&specials=$specials&count_specials=$countSpecials";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all cast and crew for a show, including the episode_count for which they appear.
     * Each cast member will have a characters array and a standard person object.
     *
     * https://trakt.docs.apiary.io/#reference/shows/people
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function people(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/people?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns rating (between 0 and 10) and distribution for a show.
     *
     * https://trakt.docs.apiary.io/#reference/shows/ratings
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function ratings(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/ratings";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns related and similar shows.
     *
     * https://trakt.docs.apiary.io/#reference/shows/related
     * @param string|int $traktId
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function related(string|int $traktId, int $page = 1, int $limit = 10): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/related?extended=full&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns lots of show stats.
     *
     * https://trakt.docs.apiary.io/#reference/shows/stats
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function stats(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/stats";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all users watching this show right now.
     *
     * https://trakt.docs.apiary.io/#reference/shows/watching
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function watching(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/watching?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the next scheduled to air episode. If no episode is found, a 204 HTTP status code will be returned.
     *
     * https://trakt.docs.apiary.io/#reference/shows/next-episode
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function nextEpisode(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/next_episode?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns the most recently aired episode. If no episode is found, a 204 HTTP status code will be returned.
     *
     * https://trakt.docs.apiary.io/#reference/shows/last-episode
     * @param string|int $traktId
     * @return JsonResponse
     */
    public function lastEpisode(string|int $traktId): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/last_episode?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all seasons for a show including the number of episodes in each season.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/summary/get-all-seasons-for-a-show
     * @param string|int $traktId
     * @param bool $includeEpisodes
     * @return JsonResponse
     */
    public function seasons(string|int $traktId, bool $includeEpisodes = false): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/seasons";
        if ($includeEpisodes) {
            $uri .= '?extended=episodes,full';
        }

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all episodes for a specific season of a show.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/summary/get-single-season-for-a-show
     * @param string|int $traktId
     * @param int $seasonNumber
     * @return JsonResponse
     */
    public function season(string|int $traktId, int $seasonNumber): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/seasons/$seasonNumber";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all cast and crew for a season, including the episode_count for which they appear.
     * Each cast member will have a characters array and a standard person object.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/people/get-all-people-for-a-season
     * @param string|int $traktId
     * @param int $seasonNumber
     * @return JsonResponse
     */
    public function seasonPeople(string|int $traktId, int $seasonNumber): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/seasons/$seasonNumber/people?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns rating (between 0 and 10) and distribution for a season.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/ratings/get-season-ratings
     * @param string|int $traktId
     * @param int $seasonNumber
     * @return JsonResponse
     */
    public function seasonRatings(string|int $traktId, int $seasonNumber): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/seasons/$seasonNumber/ratings";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns lots of season stats.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/stats/get-season-stats
     * @param string|int $traktId
     * @param int $seasonNumber
     * @return JsonResponse
     */
    public function seasonStats(string|int $traktId, int $seasonNumber): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/seasons/$seasonNumber/stats";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all users watching this season right now.
     *
     * https://trakt.docs.apiary.io/#reference/seasons/watching/get-users-watching-right-now
     * @param string|int $traktId
     * @param int $seasonNumber
     * @return JsonResponse
     */
    public function seasonWatching(string|int $traktId, int $seasonNumber): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/seasons/$seasonNumber/watching?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns a single episode's details. All date and times are in UTC and were calculated using
     * the episode's air_date and show's country and air_time.
     * Note: If the first_aired is unknown, it will be set to null.
     *
     * https://trakt.docs.apiary.io/#reference/episodes/summary/get-a-single-episode-for-a-show
     * @param string|int $traktId
     * @param int $seasonNumber
     * @param int $episodeNumber
     * @return JsonResponse
     */
    public function episode(string|int $traktId, int $seasonNumber, int $episodeNumber): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/seasons/$seasonNumber/episodes/$episodeNumber?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all cast and crew for an episode.
     * Each cast member will have a characters array and a standard person object.
     *
     * https://trakt.docs.apiary.io/#reference/episodes/people/get-all-people-for-an-episode
     * @param string|int $traktId
     * @param int $seasonNumber
     * @param int $episodeNumber
     * @return JsonResponse
     */
    public function episodePeople(string|int $traktId, int $seasonNumber, int $episodeNumber): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/seasons/$seasonNumber/episodes/$episodeNumber/people";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns rating (between 0 and 10) and distribution for an episode.
     *
     * https://trakt.docs.apiary.io/#reference/episodes/ratings/get-episode-ratings
     * @param string|int $traktId
     * @param int $seasonNumber
     * @param int $episodeNumber
     * @return JsonResponse
     */
    public function episodeRatings(string|int $traktId, int $seasonNumber, int $episodeNumber): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/seasons/$seasonNumber/episodes/$episodeNumber/ratings";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns lots of episode stats.
     *
     * https://trakt.docs.apiary.io/#reference/episodes/stats/get-episode-stats
     * @param string|int $traktId
     * @param int $seasonNumber
     * @param int $episodeNumber
     * @return JsonResponse
     */
    public function episodeStats(string|int $traktId, int $seasonNumber, int $episodeNumber): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/seasons/$seasonNumber/episodes/$episodeNumber/stats";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns all users watching this episode right now.
     *
     * https://trakt.docs.apiary.io/#reference/episodes/watching/get-users-watching-right-now
     * @param string|int $traktId
     * @param int $seasonNumber
     * @param int $episodeNumber
     * @return JsonResponse
     */
    public function episodeWatching(string|int $traktId, int $seasonNumber, int $episodeNumber): JsonResponse
    {
        $uri = $this->apiUrl . "shows/$traktId/seasons/$seasonNumber/episodes/$episodeNumber/watching?extended=full";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }
}
