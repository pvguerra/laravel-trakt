<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class TraktAuth extends LaravelTrakt
{
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
        return Http::get($this->apiUrl
            . "oauth/authorize?response_type=code"
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
            "grant_type" => "authorization_code"
        ];

        return Http::post($this->apiUrl . "oauth/token", $data);
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
            "grant_type" => "refresh_token"
        ];

        return Http::post($this->apiUrl . "oauth/token", $data);
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

        return Http::post($this->apiUrl . "oauth/revoke", $data);
    }
}