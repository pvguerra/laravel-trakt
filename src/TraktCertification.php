<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktCertification extends LaravelTrakt
{
    use HttpResponses;

    /**
     * Most TV shows and movies have a certification to indicate the content rating.
     * Some API methods allow filtering by certification, so it's good to cache this list in your app.
     * Note: Only us certifications are currently returned.
     * Get a list of all certifications, including names, slugs, and descriptions.
     *
     * https://trakt.docs.apiary.io/#reference/certifications
     * @param string $type
     * @return JsonResponse
     */
    public function certifications(string $type): JsonResponse
    {
        $uri = $this->apiUrl . "certifications/$type";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }
}