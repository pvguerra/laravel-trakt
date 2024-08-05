<?php

namespace Pvguerra\LaravelTrakt\Traits;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;

trait HttpResponses
{
    protected static function httpResponse(Response $response): JsonResponse
    {
        $rateLimit = null;

        if (isset($response->headers()['x-ratelimit'])) {
            try {
                $rateLimit = json_decode($response->headers()['x-ratelimit'][0]);
            } catch (\Exception $e) {
                $rateLimit = null;
            }
        }

        return response()->json([
            'code' => $response->status(),
            'success' => $response->successful(),
            'client_error' => $response->clientError(),
            'server_error' => $response->serverError(),
            'rate_limit' => $rateLimit,
            'data' => $response->json(),
        ], $response->status());
    }
}
