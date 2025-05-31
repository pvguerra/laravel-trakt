<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktLanguage
{

    public function __construct(protected ClientInterface $client)
    {
    }

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
        return $this->client->get("languages/$type")->json();
    }
}
