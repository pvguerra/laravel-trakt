<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktSearch
{
    public function __construct(protected ClientInterface $client)
    {
    }

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
     * @return array
     */
    public function query(
        int $page = 1,
        int $limit = 10,
        string $type = 'movie',
        string $query = 'matrix',
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, ['query' => $query]);
        return $this->client->get("search/$type", $params)->json();
    }
}
