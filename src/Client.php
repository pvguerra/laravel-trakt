<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class Client implements ClientInterface
{
    private string $baseUrl;
    private string $clientId;
    private string $clientSecret;
    private array $headers;
    private string $redirectUrl;
    private string $apiVersion = '2';
    private PendingRequest $httpClient;

    public function __construct(string $bearerToken)
    {
        $this->baseUrl = config('trakt.api_url', 'https://api.trakt.tv');
        $this->clientId = config('trakt.client_id');
        $this->clientSecret = config('trakt.client_secret');
        $this->headers = config('trakt.headers', [
            'Content-Type' => 'application/json',
            'trakt-api-version' => $this->apiVersion,
            'trakt-api-key' => $this->clientId,
        ]);
        $this->redirectUrl = config('trakt.redirect_url');

        $this->httpClient = Http::withHeaders($this->headers)
            ->baseUrl($this->baseUrl)
            ->connectTimeout(3)
            ->retry(3, 100, function ($exception) {
                return $exception instanceof ConnectionException;
            })
            ->timeout(30);

        if ($bearerToken) {
            $this->httpClient->withToken($bearerToken);
        }
    }

    /**
     * Construct then redirect to this URL. The Trakt website will request permissions for your app,
     * which the user needs to approve. If the user isn't signed in to Trakt, it will ask them to do so.
     * Send signup=true if you prefer the account sign up page to be the default.
     *
     * https://trakt.docs.apiary.io/#reference/authentication-oauth/authorize/authorize-application
     * @return Response
     */
    public function authorize(): Response
    {
        return $this->httpClient->get("oauth/authorize?response_type=code"
            . "&client_id=$this->clientId"
            . "&redirect_uri=$this->redirectUrl");
    }

    /**
     * Use the authorization code GET parameter sent back to your redirect_uri to get an access_token.
     * Save the access_token so your app can authenticate the user by sending the Authorization header.
     * The access_token is valid for 3 months. Save and use the refresh_token to get a new access_token
     * without asking the user to re-authenticate.
     *
     * https://trakt.docs.apiary.io/#reference/authentication-oauth/get-token/exchange-code-for-access_token
     * @param string $code
     * @return Response
     */
    public function getToken(string $code): Response
    {
        $data = [
            "code" => $code,
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
            "redirect_uri" => $this->redirectUrl,
            "grant_type" => "authorization_code",
        ];

        return $this->httpClient->post("oauth/token", $data);
    }

    /**
     * Use the refresh_token to get a new access_token without asking the user to re-authenticate.
     * The access_token is valid for 3 months before it needs to be refreshed again.
     *
     * https://trakt.docs.apiary.io/#reference/authentication-oauth/get-token/exchange-refresh_token-for-access_token
     * @param string $refreshToken
     * @return Response
     */
    public function refreshToken(string $refreshToken): Response
    {
        $data = [
            "refresh_token" => $refreshToken,
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
            "redirect_uri" => $this->redirectUrl,
            "grant_type" => "refresh_token",
        ];

        return $this->httpClient->post("oauth/token", $data);
    }

    /**
     * An access_token can be revoked when a user signs out of their Trakt account in your app.
     * This is not required, but might improve the user experience so the user doesn't have an unused
     * app connection hanging around.
     *
     * https://trakt.docs.apiary.io/#reference/authentication-oauth/revoke-token/revoke-an-access_token
     * @param string $token
     * @return Response
     */
    public function revokeToken(string $token): Response
    {
        $data = [
            "token" => $token,
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
        ];

        return $this->httpClient->post("oauth/revoke", $data);
    }

    /**
     * Generate device codes.
     *
     * https://trakt.docs.apiary.io/#reference/authentication-devices/device-code/generate-new-device-codes
     * @return Response
     */
    public function generateDeviceCodes(): Response
    {
        $data = [
            'client_id' => $this->clientId,
        ];

        return $this->httpClient->post("oauth/device/code", $data);
    }

    /**
     * Get device token.
     *
     * https://trakt.docs.apiary.io/#reference/authentication-devices/get-token/poll-for-the-access_token
     * @param string $code
     * @return Response
     */
    public function getDeviceToken(string $code): Response
    {
        $data = [
            "code" => $code,
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
        ];

        return $this->httpClient->post("oauth/device/token", $data);
    }

    /**
     * Make a GET request to the Trakt API.
     *
     * @param string $endpoint
     * @param array $params
     * @return Response
     */
    public function get(string $endpoint, array $params = []): Response
    {
        return $this->httpClient->get($endpoint, $params);
    }

    /**
     * Make a POST request to the Trakt API.
     *
     * @param string $endpoint
     * @param array $data
     * @return Response
     */
    public function post(string $endpoint, array $data = []): Response
    {
        return $this->httpClient->post($endpoint, $data);
    }

    /**
     * Make a PUT request to the Trakt API.
     *
     * @param string $endpoint
     * @param array $data
     * @return Response
     */
    public function put(string $endpoint, array $data = []): Response
    {
        return $this->httpClient->put($endpoint, $data);
    }

    /**
     * Make a DELETE request to the Trakt API.
     *
     * @param string $endpoint
     * @param array $params
     * @return Response
     */
    public function delete(string $endpoint, array $params = []): Response
    {
        return $this->httpClient->delete($endpoint, $params);
    }

    /**
     * Build a query string from an array of parameters.
     *
     * @param array $params
     * @return string
     */
    public function buildQueryString(array $params): string
    {
        if (empty($params)) {
            return '';
        }
        
        return '?' . http_build_query($params);
    }

    /**
     * Build pagination parameters.
     *
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function buildPaginationParams(int $page = 1, int $limit = 10): array
    {
        return [
            'page' => $page,
            'limit' => $limit
        ];
    }

    /**
     * Build extended parameters.
     *
     * @param bool $extended
     * @param ?string $level
     * @return array
     */
    public function buildExtendedParams(bool $extended, ?string $level): array
    {
        $params = [];
        
        if ($extended && $level) {
            $params['extended'] = $level;
        }
        
        return $params;
    }
    
    /**
     * Add filters to parameters.
     *
     * @param array $params
     * @param ?string $filters
     * @return array
     */
    public function addFiltersToParams(array $params, ?string $filters): array
    {
        if ($filters) {
            parse_str($filters, $filterParams);
            $params = array_merge($params, $filterParams);
        }
        
        return $params;
    }

    /**
     * Get headers.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get base URL.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
