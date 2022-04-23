<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktCountry extends LaravelTrakt
{
    use HttpResponses;

    /**
     * Some API methods allow filtering by country code, so it's good to cache this list in your app.
     * Get a list of all countries, including names and codes.
     *
     * https://trakt.docs.apiary.io/#reference/countries
     * @param string $type
     * @return JsonResponse
     */
    public function countries(string $type): JsonResponse
    {
        $uri = $this->apiUrl . "countries/$type";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }
}