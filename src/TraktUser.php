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
     * @return Response
     */
    public function denyRequest(int $requestId): Response
    {
        $uri = $this->apiUrl . "users/requests/$requestId";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->delete($uri);
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

    /**
     * Get items a user likes. This will return an array of standard media objects.
     * You can optionally limit the type of results to return.
     *
     * https://trakt.docs.apiary.io/#reference/users/likes
     * @param string $traktId
     * @param string $type
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function likes(string $traktId, string $type = 'lists', int $page = 1, int $limit = 10): array
    {
        $uri = $this->apiUrl . "users/$traktId/likes/$type?page=$page&limit=$limit";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }

    /**
     * Get all collected items in a user's collection.
     * A collected item indicates availability to watch digitally or on physical media.
     *
     * https://trakt.docs.apiary.io/#reference/users/collection
     * @param string $traktId
     * @param string $type
     * @return array
     */
    public function collection(string $traktId, string $type): array
    {
        $uri = $this->apiUrl . "users/$traktId/collection/$type?extended=metadata";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }

    /**
     * Returns all custom lists for a user. Use the /users/:id/lists/:list_id/items method to
     * get the actual items a specific list contains.
     *
     * https://trakt.docs.apiary.io/#reference/users/lists/get-a-user's-custom-lists
     * @param string $traktId
     * @return array
     */
    public function lists(string $traktId): array
    {
        $uri = $this->apiUrl . "users/$traktId/lists";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }

    /**
     * Create a new custom list. The name is the only required field, but the other info is recommended to ask for.
     *
     * https://trakt.docs.apiary.io/#reference/users/lists/create-custom-list
     * @param string $traktId
     * @param array $data
     * @return Response
     */
    public function createList(string $traktId, array $data): Response
    {
        $uri = $this->apiUrl . "users/$traktId/lists";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);
    }

    /**
     * Reorder all lists by sending the updated rank of list ids. Use the /users/:id/lists method to get all list ids.
     *
     * https://trakt.docs.apiary.io/#reference/users/reorder-lists/reorder-a-user's-lists
     * @param string $traktId
     * @param array $data
     * @return Response
     */
    public function reorderLists(string $traktId, array $data): Response
    {
        $uri = $this->apiUrl . "users/$traktId/lists/reorder";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);
    }

    /**
     * Returns a single custom list. Use the /users/:id/lists/:list_id/items method to get
     * the actual items this list contains.
     *
     * https://trakt.docs.apiary.io/#reference/users/list/get-custom-list
     * @param string $traktId
     * @param string $listId
     * @return array
     */
    public function getList(string $traktId, string $listId): array
    {
        $uri = $this->apiUrl . "users/$traktId/lists/$listId";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }

    /**
     * Update a custom list by sending 1 or more parameters. If you update the list name,
     * the original slug will still be retained so existing references to this list won't break.
     *
     * https://trakt.docs.apiary.io/#reference/users/list/update-custom-list
     * @param string $traktId
     * @param string $listId
     * @param array $data
     * @return Response
     */
    public function updateList(string $traktId, string $listId, array $data): Response
    {
        $uri = $this->apiUrl . "users/$traktId/lists/$listId";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->put($uri, $data);
    }

    /**
     * Remove a custom list and all items it contains.
     *
     * https://trakt.docs.apiary.io/#reference/users/list/delete-a-user's-custom-list
     * @param string $traktId
     * @param string $listId
     * @return Response
     */
    public function deleteList(string $traktId, string $listId): Response
    {
        $uri = $this->apiUrl . "users/$traktId/lists/$listId";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->delete($uri);
    }

    /**
     * Get all items on a custom list. Items can be a movie, show, season, episode, or person.
     * You can optionally specify the type parameter with a single value or comma delimited string
     * for multiple item types.
     *
     * https://trakt.docs.apiary.io/#reference/users/list-items/get-items-on-a-custom-list
     * @param int $traktId
     * @param string $type
     * @param string $listId
     * @return array
     */
    public function listItems(int $traktId, string $listId, string $type): array
    {
        $uri = $this->apiUrl . "users/$traktId/lists/$listId/items/$type";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->get($uri)->json();
    }

    /**
     * Add one or more items to a custom list. Items can be movies, shows, seasons, episodes, or people.
     *
     * https://trakt.docs.apiary.io/#reference/users/list-items/add-items-to-custom-list
     * @param int $traktId
     * @param string $listId
     * @param array $data
     * @return Response
     */
    public function addItemToList(int $traktId, string $listId, array $data): Response
    {
        $uri = $this->apiUrl . "users/$traktId/lists/$listId/items";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);
    }

    /**
     * Remove one or more items from a custom list.
     *
     * https://trakt.docs.apiary.io/#reference/users/remove-list-items/remove-items-from-custom-list
     * @param int $traktId
     * @param string $listId
     * @param array $data
     * @return Response
     */
    public function removeItemFromList(int $traktId, string $listId, array $data): Response
    {
        $uri = $this->apiUrl . "users/$traktId/lists/$listId/items/remove";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);
    }

    /**
     * Reorder all items on a list by sending the updated rank of list item ids.
     * Use the /users/:id/lists/:list_id/items method to get all list item ids.
     *
     * https://trakt.docs.apiary.io/#reference/users/reorder-list-items/reorder-items-on-a-list
     * @param string $traktId
     * @param string $listId
     * @param array $data
     * @return Response
     */
    public function reorderItemsOnList(string $traktId, string $listId, array $data): Response
    {
        $uri = $this->apiUrl . "users/$traktId/lists/$listId/items/reorder";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri, $data);
    }

    /**
     * If the user has a private profile, the follow request will require approval (approved_at will be null).
     * If a user is public, they will be followed immediately (approved_at will have a date).
     * Note: If this user is already being followed, a 409 HTTP status code will returned.
     *
     * https://trakt.docs.apiary.io/#reference/users/follow/follow-this-user
     * @param string $traktId
     * @return Response
     */
    public function follow(string $traktId): Response
    {
        $uri = $this->apiUrl . "users/$traktId/follow";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->post($uri);
    }

    /**
     * If the user has a private profile, the follow request will require approval (approved_at will be null).
     * If a user is public, they will be followed immediately (approved_at will have a date).
     * Note: If this user is already being followed, a 409 HTTP status code will returned.
     *
     * https://trakt.docs.apiary.io/#reference/users/follow/unfollow-this-user
     * @param string $traktId
     * @return Response
     */
    public function unfollow(string $traktId): Response
    {
        $uri = $this->apiUrl . "users/$traktId/follow";

        return Http::withHeaders($this->headers)->withToken($this->apiToken)->delete($uri);
    }
}