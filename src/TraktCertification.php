<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktCertification
{

    public function __construct(protected ClientInterface $client)
    {
    }

    /**
     * Most TV shows and movies have a certification to indicate the content rating.
     * Some API methods allow filtering by certification, so it's good to cache this list in your app.
     * Note: Only US certifications are currently returned.
     * Get a list of all certifications, including names, slugs, and descriptions.
     *
     * https://trakt.docs.apiary.io/#reference/certifications
     * @param string $type
     * @return array
     */
    public function certifications(string $type): array
    {
        return $this->client->get("certifications/$type")->json();
    }
}
