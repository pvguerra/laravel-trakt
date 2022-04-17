<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Support\Facades\Http;

class TraktCertification extends LaravelTrakt
{
    /**
     * Most TV shows and movies have a certification to indicate the content rating.
     * Some API methods allow filtering by certification, so it's good to cache this list in your app.
     * Note: Only us certifications are currently returned.
     * Get a list of all certifications, including names, slugs, and descriptions.
     *
     * https://trakt.docs.apiary.io/#reference/certifications
     * @param string $type
     * @return array
     */
    public function certifications(string $type): array
    {
        $uri = $this->apiUrl . "certifications/$type";

        return Http::withHeaders($this->headers)->get($uri)->json();
    }
}