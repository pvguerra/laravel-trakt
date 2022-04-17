<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Support\Facades\Http;

class TraktLanguage extends LaravelTrakt
{
    /**
     * Some API methods allow filtering by language code, so it's good to cache this list in your app.
     * Get a list of all languages, including names and codes.
     *
     * https://trakt.docs.apiary.io/#reference/languages
     * @param string $type
     * @return array
     */
    public function languages(string $type): array
    {
        $uri = $this->apiUrl . "languages/$type";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }
}