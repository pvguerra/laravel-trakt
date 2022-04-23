<?php

namespace Pvguerra\LaravelTrakt\Traits;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;

trait HttpResponses
{
    protected static function httpResponse(Response $response): JsonResponse
    {
        return response()->json([
            'code' => $response->status(),
            'success' => $response->successful(),
            'client_error' => $response->clientError(),
            'server_error' => $response->serverError(),
            'data' => $response,
        ], $response->status());
    }
}