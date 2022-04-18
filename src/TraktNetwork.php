<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Support\Facades\Http;

class TraktNetwork extends LaravelTrakt
{
    /**
     * Most TV shows have a TV network where it originally aired.
     * Some API methods allow filtering by network, so it's good to cache this list in your app.
     *
     * https://trakt.docs.apiary.io/#reference/networks
     * @return array
     */
    public function genres(): array
    {
        $uri = $this->apiUrl . "networks";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }
}