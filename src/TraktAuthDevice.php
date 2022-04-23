<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Support\Facades\Http;

class TraktAuthDevice extends LaravelTrakt
{
    public function generateDeviceCodes()
    {
        $data = [
            'client_id' => $this->clientId
        ];

        return Http::post($this->apiUrl . "oauth/device/code", $data);
    }

    public function getToken(string $code)
    {
        $data = [
            "code" => $code,
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
        ];

        return Http::post($this->apiUrl . "oauth/device/token", $data);
    }
}