<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktGenre extends LaravelTrakt
{
    use HttpResponses;

    /**
     * One or more genres are attached to all movies and shows.
     * Some API methods allow filtering by genre, so it's good to cache this list in your app.
     * Get a list of all genres, including names and slugs.
     *
     * https://trakt.docs.apiary.io/#reference/genres
     * @param string $type
     * @return JsonResponse
     */
    public function genres(string $type): JsonResponse
    {
        $uri = $this->apiUrl . "genres/$type";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }
}