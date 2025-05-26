<?php

namespace Pvguerra\LaravelTrakt;

class TraktCountry
{
    public function __construct(protected Client $client)
    {
    }

    /**
     * Some API methods allow filtering by country code, so it's good to cache this list in your app.
     * Get a list of all countries, including names and codes.
     *
     * https://trakt.docs.apiary.io/#reference/countries
     * @param string $type
     * @return array
     */
    public function countries(string $type): array
    {
        return $this->client->get("countries/$type")->json();
    }
}
