<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Traits\HttpResponses;

class TraktSearch extends LaravelTrakt
{
    use HttpResponses;

    /**
     * Search all text fields that a media object contains (i.e. title, overview, etc).
     * Results are ordered by the most relevant score. Specify the type of results by
     * sending a single value or a comma delimited string for multiple types.
     *
     * https://trakt.docs.apiary.io/#reference/search/text-query/get-text-query-results
     * @param string $type
     * @param string $query
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    public function query(
        string $type = 'personal',
        string $query = 'popular',
        int $page = 1,
        int $limit = 10
    ): JsonResponse {
        $uri = $this->apiUrl . "search/$type?query=$query&page=$page&limit=$limit";

        $response = Http::withHeaders($this->headers)->get($uri);

        return self::httpResponse($response);
    }
}
