<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktNetwork extends LaravelTrakt
{
    use HttpResponses;

    /**
     * Most TV shows have a TV network where it originally aired.
     * Some API methods allow filtering by network, so it's good to cache this list in your app.
     *
     * https://trakt.docs.apiary.io/#reference/networks
     * @return JsonResponse
     */
    public function genres(): JsonResponse
    {
        $uri = $this->apiUrl . "networks";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }
}