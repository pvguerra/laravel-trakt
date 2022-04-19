<?php

namespace Pvguerra\LaravelTrakt;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class TraktUser extends LaravelTrakt
{
    /**
     * Get the user's settings, so you can align your app's experience with what they're used to on the trakt website.
     * A globally unique uuid is also returned, which can be used to identify the user locally in your app if needed.
     * However, the uuid can't be used to retrieve data from the Trakt API.
     *
     * https://trakt.docs.apiary.io/#reference/users/retrieve-settings
     * @return array
     */
    public function settings(): array
    {
        $uri = $this->apiUrl . "users/settings";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }

    /**
     * List a user's pending following requests that they're waiting for the other user's to approve.
     *
     * https://trakt.docs.apiary.io/#reference/users/following-requests
     * @return array
     */
    public function followingRequests(): array
    {
        $uri = $this->apiUrl . "users/requests/following";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }

    /**
     * List a user's pending follow requests, so they can either approve or deny them.
     *
     * https://trakt.docs.apiary.io/#reference/users/requests
     * @return array
     */
    public function requests(): array
    {
        $uri = $this->apiUrl . "users/requests";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }

    /**
     * Approve a follower using the id of the request. If the id is not found, was already approved,
     * or was already denied, a 404 error will be returned.
     *
     * https://trakt.docs.apiary.io/#reference/users/approve-or-deny-follower-requests
     * @param int $requestId
     * @return array
     */
    public function approveRequest(int $requestId): array
    {
        $uri = $this->apiUrl . "users/requests/$requestId";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri)->json();
    }

    /**
     * Deny a follower using the id of the request. If the id is not found, was already approved,
     * or was already denied, a 404 error will be returned.
     *
     * https://trakt.docs.apiary.io/#reference/users/approve-or-deny-follower-requests
     * @param int $requestId
     * @return array
     */
    public function denyRequest(int $requestId): array
    {
        $uri = $this->apiUrl . "users/requests/$requestId";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->delete($uri)->json();
    }

    /**
     * Get hidden items for a section. This will return an array of standard media objects.
     * You can optionally limit the type of results to return.
     *
     * https://trakt.docs.apiary.io/#reference/users/hidden-items
     * @param string $section
     * @param string $type
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function hiddenItems(string $section, string $type, int $page = 1, int $limit = 10): array
    {
        $uri = $this->apiUrl . "users/hidden/$section?type=$type?extended=full&page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }

    /**
     * Hide items for a specific section. Here's what type of items can be hidden for each section.
     *
     * https://trakt.docs.apiary.io/#reference/users/add-hidden-items
     * @param string $section
     * @param array $data
     * @return Response
     */
    public function addHiddenItems(string $section, array $data): Response
    {
        $uri = $this->apiUrl . "users/hidden/$section";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);
    }

    /**
     * Reveal items for a specific section. Here's what type of items can unhidden for each section.
     *
     * https://trakt.docs.apiary.io/#reference/users/remove-hidden-items
     * @param string $section
     * @param array $data
     * @return Response
     */
    public function removeHiddenItems(string $section, array $data): Response
    {
        $uri = $this->apiUrl . "users/hidden/$section/remove";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);
    }

    /**
     * Get a user's profile information. If the user is private, info will only be returned if
     * you send OAuth and are either that user or an approved follower.
     * Adding ?extended=vip will return some additional VIP related fields then you can display
     * the user's Trakt VIP status and year count.
     *
     * https://trakt.docs.apiary.io/#reference/users/profile
     * @param string $traktId
     * @return array
     */
    public function profile(string $traktId): array
    {
        $uri = $this->apiUrl . "users/$traktId?extended=vip";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }
}