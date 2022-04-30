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
}
