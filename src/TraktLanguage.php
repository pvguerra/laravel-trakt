<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktLanguage extends LaravelTrakt
{
    use HttpResponses;

    /**
     * Some API methods allow filtering by language code, so it's good to cache this list in your app.
     * Get a list of all languages, including names and codes.
     *
     * https://trakt.docs.apiary.io/#reference/languages
     * @param string $type
     * @return JsonResponse
     */
    public function languages(string $type): JsonResponse
    {
        $uri = $this->apiUrl . "languages/$type";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }
}
