<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktNetwork
{
    public function __construct(protected ClientInterface $client)
    {
    }

    /**
     * Most TV shows have a TV network where it originally aired.
     * Some API methods allow filtering by network, so it's good to cache this list in your app.
     *
     * https://trakt.docs.apiary.io/#reference/networks
     * @return array
     */
    public function genres(): array
    {
        return $this->client->get("networks")->json();
    }
}
