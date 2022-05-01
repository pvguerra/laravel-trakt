<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktCheckIn extends LaravelTrakt
{
    use HttpResponses;

    /**
     * Check into a movie or episode. This should be tied to a user action to manually
     * indicate they are watching something. The item will display as watching on the site,
     * then automatically switch to watched status once the duration has elapsed.
     *
     * https://trakt.docs.apiary.io/#reference/checkin/checkin/check-into-an-item
     * @param array $data
     * @return JsonResponse
     */
    public function checkIn(array $data): JsonResponse
    {
        $uri = $this->apiUrl . "checkin";

        $response = Http::withHeaders($this->headers)->post($uri, $data);

        return self::httpResponse($response);
    }

    /**
     * Removes any active checkins, no need to provide a specific item.
     *
     * https://trakt.docs.apiary.io/#reference/checkin/checkin/delete-any-active-checkins
     * @return JsonResponse
     */
    public function deleteCheckIns(): JsonResponse
    {
        $uri = $this->apiUrl . "checkin";

        $response = Http::withHeaders($this->headers)->delete($uri);

        return self::httpResponse($response);
    }
}
