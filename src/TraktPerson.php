<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktPerson
{
    public function __construct(protected ClientInterface $client)
    {
    }

    /**
     * Returns a single person's details.
     *
     * https://trakt.docs.apiary.io/#reference/people/summary
     * @param string|int $traktId
     * @return array
     */
    public function get(
        string|int $traktId,
        bool $extended = false,
        ?string $level = null
    ): array {
        $params = $this->client->buildExtendedParams($extended, $level);
        return $this->client->get("people/{$traktId}", $params)->json();
    }

    /**
     * Returns all movies where this person is in the cast or crew.
     * Each cast object will have a characters array and a standard movie object.
     *
     * https://trakt.docs.apiary.io/#reference/people/summary/get-movie-credits
     * @param string|int $traktId
     * @return array
     */
    public function getMovieCredits(
        string|int $traktId,
        bool $extended = false,
        ?string $level = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        return $this->client->get("people/{$traktId}/movies", $params)->json();
    }

    /**
     * Returns all shows where this person is in the cast or crew, including the episode_count for which they appear.
     * Each cast object will have a characters array and a standard show object.
     * If series_regular is true, this person is a series regular and not simply a guest star.
     *
     * https://trakt.docs.apiary.io/#reference/people/summary/get-show-credits
     * @param string|int $traktId
     * @return array
     */
    public function getShowCredits(
        string|int $traktId,
        bool $extended = false,
        ?string $level = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        return $this->client->get("people/{$traktId}/shows", $params)->json();
    }

    /**
     * Returns all lists that contain this person. By default, personal lists are returned sorted by the most popular.
     *
     * https://trakt.docs.apiary.io/#reference/people/summary/get-lists-containing-this-person
     * @param string|int $traktId
     * @param string $type
     * @param string $sort
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function lists(
        string|int $traktId,
        string $type = 'personal',
        string $sort = 'popular',
        int $page = 1,
        int $limit = 10,
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);
        return $this->client->get("people/{$traktId}/lists/{$type}/{$sort}", $params)->json();
    }
}
