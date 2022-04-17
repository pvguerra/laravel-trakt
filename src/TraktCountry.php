<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Support\Facades\Http;

class TraktCountry extends LaravelTrakt
{
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
        $uri = $this->apiUrl . "countries/$type";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }
}