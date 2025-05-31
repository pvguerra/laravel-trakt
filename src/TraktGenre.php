<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktGenre
{
    public function __construct(protected ClientInterface $client)
    {
    }

    /**
     * One or more genres are attached to all movies and shows.
     * Some API methods allow filtering by genre, so it's good to cache this list in your app.
     * Get a list of all genres, including names and slugs.
     *
     * https://trakt.docs.apiary.io/#reference/genres
     * @param string $type
     * @return array
     */
    public function genres(string $type): array
    {
        return $this->client->get("genres/$type")->json();
    }
}
