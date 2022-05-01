<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktSync extends LaravelTrakt
{
    use HttpResponses;

    /**
     * This method is a useful first step in the syncing process. We recommended caching these dates locally,
     * then you can compare to know exactly what data has changed recently. This can greatly optimize your
     * syncs so, you don't pull down a ton of data only to see nothing has actually changed.
     *
     * https://trakt.docs.apiary.io/#reference/sync/last-activities/get-last-activity
     * @return JsonResponse
     */
    public function lastActivities(): JsonResponse
    {
        $uri = $this->apiUrl . "sync/last_activities";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Get all collected items in a user's collection. A collected item indicates availability
     * to watch digitally or on physical media.
     *
     * https://trakt.docs.apiary.io/#reference/sync/get-collection/get-collection
     * @param string $type
     * @return JsonResponse
     */
    public function collection(string $type): JsonResponse
    {
        $uri = $this->apiUrl . "sync/collection/$type?extended=full";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Add items to a user's collection. Accepts shows, seasons, episodes and movies.
     * If only a show is passed, all episodes for the show will be collected.
     * If seasons are specified, all episodes in those seasons will be collected.
     *
     * https://trakt.docs.apiary.io/#reference/sync/get-collection/add-items-to-collection
     * @param array $data
     * @return JsonResponse
     */
    public function addToCollection(array $data): JsonResponse
    {
        $uri = $this->apiUrl . "sync/collection";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);

        return self::httpResponse($response);
    }

    /**
     * Remove one or more items from a user's collection.
     *
     * https://trakt.docs.apiary.io/#reference/sync/remove-from-collection/remove-items-from-collection
     * @param array $data
     * @return JsonResponse
     */
    public function removeFromCollection(array $data): JsonResponse
    {
        $uri = $this->apiUrl . "sync/collection/remove";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);

        return self::httpResponse($response);
    }

    /**
     * Returns all movies or shows a user has watched sorted by most plays.
     *
     * https://trakt.docs.apiary.io/#reference/sync/get-watched/get-watched
     * @param string $type
     * @return JsonResponse
     */
    public function watched(string $type): JsonResponse
    {
        $uri = $this->apiUrl . "sync/watched/$type?extended=full";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Returns movies and episodes that a user has watched, sorted by most recent.
     * You can optionally limit the type to movies or episodes.
     * The id (64-bit integer) in each history item uniquely identifies the event and can be used
     * to remove individual events by using the /sync/history/remove method.
     * The action will be set to scrobble, checkin, or watch.Specify a type and trakt item_id to
     * limit the history for just that item. If the item_id is valid, but there is no history,
     * an empty array will be returned.
     *
     * https://trakt.docs.apiary.io/#reference/sync/get-history/get-watched-history
     * @param string $traktId
     * @param string $type
     * @param string $startAt
     * @param string $endAt
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function history(
        string $traktId,
        string $type,
        string $startAt,
        string $endAt,
        int $page = 1,
        int $limit = 10
    ): JsonResponse {
        $uri = $this->apiUrl
            . "sync/history/$type/$traktId?extended=full"
            . "&start_at=$startAt&end_at=$endAt"
            . "&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Add items to a user's watch history. Accept shows, seasons, episodes and movies.
     * If only a show is passed, all episodes for the show will be added.
     * If seasons are specified, only episodes in those seasons will be added.
     *
     * https://trakt.docs.apiary.io/#reference/sync/add-to-history/add-items-to-watched-history
     * @param array $data
     * @return JsonResponse
     */
    public function addToHistory(array $data): JsonResponse
    {
        $uri = $this->apiUrl . "sync/history";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);

        return self::httpResponse($response);
    }

    /**
     * Remove items from a user's watch history including all watches, scrobbles, and checkins.
     * Accepts shows, seasons, episodes and movies. If only a show is passed, all episodes for
     * the show will be removed. If seasons are specified, only episodes in those seasons will be removed.
     *
     * https://trakt.docs.apiary.io/#reference/sync/add-to-history/remove-items-from-history
     * @param array $data
     * @return JsonResponse
     */
    public function removeFromHistory(array $data): JsonResponse
    {
        $uri = $this->apiUrl . "sync/history/remove";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);

        return self::httpResponse($response);
    }

    /**
     * Get a user's ratings filtered by type. You can optionally filter for a specific rating between 1 and 10.
     * Send a comma separated string for rating if you need multiple ratings.
     *
     * https://trakt.docs.apiary.io/#reference/sync/get-ratings/get-ratings
     * @param string $type
     * @param ?int $rating
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function ratings(
        string $type,
        ?int $rating = null,
        int $page = 1,
        int $limit = 10
    ): JsonResponse {
        $uri = $this->apiUrl
            . "sync/ratings/$type"
            . ($rating ? "/$rating" : "")
            . "?extended=full&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Rate one or more items. Accept shows, seasons, episodes and movies. If only a show is passed,
     * only the show itself will be rated. If seasons are specified, all of those seasons will be rated.
     *
     * https://trakt.docs.apiary.io/#reference/sync/get-ratings/add-new-ratings
     * @param array $data
     * @return JsonResponse
     */
    public function addRating(array $data): JsonResponse
    {
        $uri = $this->apiUrl . "sync/ratings";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);

        return self::httpResponse($response);
    }

    /**
     * Remove ratings for one or more items.
     *
     * https://trakt.docs.apiary.io/#reference/sync/remove-ratings/remove-ratings
     * @param array $data
     * @return JsonResponse
     */
    public function removeRating(array $data): JsonResponse
    {
        $uri = $this->apiUrl . "sync/ratings/remove";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);

        return self::httpResponse($response);
    }

    /**
     * Returns all items in a user's watchlist filtered by type.
     *
     * https://trakt.docs.apiary.io/#reference/sync/get-watchlist/get-watchlist
     * @param string $type
     * @param string $sort
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function watchlist(
        string $type,
        string $sort = 'rank',
        int $page = 1,
        int $limit = 10
    ): JsonResponse {
        $uri = $this->apiUrl . "sync/watchlist/$type/$sort?extended=full&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Add one of more items to a user's watchlist. Accept shows, seasons, episodes and movies.
     * If only a show is passed, only the show itself will be added. If seasons are specified,
     * all of those seasons will be added.
     *
     * https://trakt.docs.apiary.io/#reference/sync/add-to-watchlist/add-items-to-watchlist
     * @param array $data
     * @return JsonResponse
     */
    public function addToWatchlist(array $data): JsonResponse
    {
        $uri = $this->apiUrl . "sync/watchlist";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);

        return self::httpResponse($response);
    }

    /**
     * Remove one or more items from a user's watchlist.
     *
     * https://trakt.docs.apiary.io/#reference/sync/remove-from-watchlist/remove-items-from-watchlist
     * @param array $data
     * @return JsonResponse
     */
    public function removeFromWatchlist(array $data): JsonResponse
    {
        $uri = $this->apiUrl . "sync/watchlist/remove";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);

        return self::httpResponse($response);
    }

    /**
     * Returns all items a user personally recommends to others including optional notes explaining
     * why they recommended an item. These recommendations are used to enhance Trakt's social
     * recommendation algorithm. Apps should encourage user's to build their personal recommendations
     * so the algorithm keeps getting better.
     *
     * https://trakt.docs.apiary.io/#reference/sync/get-personal-recommendations/get-personal-recommendations
     * @param string $type
     * @param string $sort
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function recommendations(
        string $type,
        string $sort = 'rank',
        int $page = 1,
        int $limit = 10
    ): JsonResponse {
        $uri = $this->apiUrl . "sync/recommendations/$type/$sort?extended=full&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri);

        return self::httpResponse($response);
    }

    /**
     * Add items to a user's personal recommendations including optional notes
     * (255 maximum characters) explaining why they recommended an item.
     *
     * https://trakt.docs.apiary.io/#reference/sync/get-personal-recommendations/add-items-to-personal-recommendations
     * @param array $data
     * @return JsonResponse
     */
    public function addToRecommendation(array $data): JsonResponse
    {
        $uri = $this->apiUrl . "sync/recommendations";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);

        return self::httpResponse($response);
    }

    /**
     * Remove items from a user's personal recommendations.
     *
     * https://trakt.docs.apiary.io/#reference/sync/remove-from-personal-recommendations/remove-items-from-personal-recommendations
     * @param array $data
     * @return JsonResponse
     */
    public function removeFromRecommendation(array $data): JsonResponse
    {
        $uri = $this->apiUrl . "sync/recommendations/remove";

        $response = Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);

        return self::httpResponse($response);
    }
}
