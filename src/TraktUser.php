<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktUser
{
    public function __construct(protected ClientInterface $client)
    {
    }

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
        return $this->client->get("users/settings")->json();
    }

    /**
     * List a user's pending following requests that they're waiting for the other user's to approve.
     *
     * https://trakt.docs.apiary.io/#reference/users/following-requests
     * @return array
     */
    public function followingRequests(): array
    {
        return $this->client->get("users/requests/following")->json();
    }

    /**
     * List a user's pending follow requests, so they can either approve or deny them.
     *
     * https://trakt.docs.apiary.io/#reference/users/requests
     * @return array
     */
    public function requests(): array
    {
        return $this->client->get("users/requests")->json();
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
        return $this->client->post("users/requests/$requestId")->json();
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
        return $this->client->delete("users/requests/$requestId")->json();
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
    public function hiddenItems(
        int $page = 1,
        int $limit = 10,
        string $section = 'calendar',
        string $type = 'movie',
        bool $extended = false,
        ?string $level = null
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));
        $params = array_merge($params, ['type' => $type]);
        $queryString = $this->client->buildQueryString($params);
        
        return $this->client->get("users/hidden/{$section}{$queryString}")->json();
    }

    /**
     * Hide items for a specific section. Here's what type of items can be hidden for each section.
     *
     * https://trakt.docs.apiary.io/#reference/users/add-hidden-items
     * @param string $section
     * @param array $data
     * @return array
     */
    public function addHiddenItems(string $section = 'calendar', array $data): array
    {
        return $this->client->post("users/hidden/{$section}", $data)->json();
    }

    /**
     * Reveal items for a specific section. Here's what type of items can unhidden for each section.
     *
     * https://trakt.docs.apiary.io/#reference/users/remove-hidden-items
     * @param string $section
     * @param array $data
     * @return array
     */
    public function removeHiddenItems(string $section, array $data): array
    {
        return $this->client->post("users/hidden/{$section}/remove", $data)->json();
    }

    /**
     * Get a user's profile information. If the user is private, info will only be returned if
     * you send OAuth and are either that user or an approved follower.
     * Adding ?extended=vip will return some additional VIP related fields then you can display
     * the user's Trakt VIP status and year count.
     *
     * https://trakt.docs.apiary.io/#reference/users/profile
     * @param string $traktId
     * @param bool $extended
     * @param string|null $level
     * @return array
     */
    public function profile(string $traktId, bool $extended = false, ?string $level = null): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);
        return $this->client->get("users/{$traktId}", $params)->json();
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
    public function likes(
        string $traktId,
        string $type = 'lists',
        int $page = 1,
        int $limit = 10,
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);
        return $this->client->get("users/{$traktId}/likes/{$type}", $params)->json();
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
    public function collection(
        string $traktId,
        string $type,
        bool $extended = true,
        ?string $level = 'metadata'
    ): array {
        $params = $this->client->buildExtendedParams($extended, $level);
        return $this->client->get("users/{$traktId}/collection/{$type}", $params)->json();
    }

    /**
     * Returns all personal lists for a user. Use the /users/:id/lists/:list_id/items method to
     * get the actual items a specific list contains.
     *
     * https://trakt.docs.apiary.io/#reference/users/lists/get-a-user's-personal-lists
     * @param string $traktId
     * @return array
     */
    public function lists(string $traktId): array
    {
        return $this->client->get("users/{$traktId}/lists")->json();
    }

    /**
     * Create a new custom list. The name is the only required field, but the other info is recommended to ask for.
     *
     * https://trakt.docs.apiary.io/#reference/users/lists/create-custom-list
     * @param string $traktId
     * @param array $data
     * @return array
     */
    public function createList(string $traktId, array $data): array
    {
        return $this->client->post("users/{$traktId}/lists", $data)->json();
    }

    /**
     * Reorder all lists by sending the updated rank of list ids. Use the /users/:id/lists method to get all list ids.
     *
     * https://trakt.docs.apiary.io/#reference/users/reorder-lists/reorder-a-user's-lists
     * @param string $traktId
     * @param array $data
     * @return array
     */
    public function reorderLists(string $traktId, array $data): array
    {
        return $this->client->post("users/{$traktId}/lists/reorder", $data)->json();
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
        return $this->client->get("users/{$traktId}/lists/{$listId}")->json();
    }

    /**
     * Update a custom list by sending 1 or more parameters. If you update the list name,
     * the original slug will still be retained so existing references to this list won't break.
     *
     * https://trakt.docs.apiary.io/#reference/users/list/update-custom-list
     * @param string $traktId
     * @param string $listId
     * @param array $data
     * @return array
     */
    public function updateList(string $traktId, string $listId, array $data): array
    {
        return $this->client->put("users/{$traktId}/lists/{$listId}", $data)->json();
    }

    /**
     * Remove a custom list and all items it contains.
     *
     * https://trakt.docs.apiary.io/#reference/users/list/delete-a-user's-custom-list
     * @param string $traktId
     * @param string $listId
     * @return array
     */
    public function deleteList(string $traktId, string $listId): array
    {
        return $this->client->delete("users/{$traktId}/lists/{$listId}")->json();
    }

    /**
     * Get all items on a personal list. Items can be a movie, show, season, episode, or person.
     * You can optionally specify the type parameter with a single value or comma delimited string
     * for multiple item types.
     *
     * https://trakt.docs.apiary.io/#reference/users/list-items/get-items-on-a-personal-list
     * @param string $traktId
     * @param string $listId
     * @param string $type
     * @param string $sortBy
     * @param string $sortHow
     * @param int $page
     * @param int $limit
     * @param bool $extended
     * @param ?string $level
     * @return array
     */
    public function listItems(
        string $traktId,
        string $listId,
        string $type = 'movies',
        string $sortBy = 'rank',
        string $sortHow = 'asc',
        int $page = 1,
        int $limit = 10,
        bool $extended = false,
        ?string $level = null
    ): array
    {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));

        return $this->client->get("users/{$traktId}/lists/{$listId}/items/{$type}/{$sortBy}/{$sortHow}", $params)->json();
    }

    /**
     * Add one or more items to a custom list. Items can be movies, shows, seasons, episodes, or people.
     *
     * https://trakt.docs.apiary.io/#reference/users/list-items/add-items-to-custom-list
     * @param string $traktId
     * @param string $listId
     * @param array $data
     * @return array
     */
    public function addItemToList(string $traktId, string $listId, array $data): array
    {
        return $this->client->post("users/{$traktId}/lists/{$listId}/items", $data)->json();
    }

    /**
     * Remove one or more items from a custom list.
     *
     * https://trakt.docs.apiary.io/#reference/users/remove-list-items/remove-items-from-custom-list
     * @param string $traktId
     * @param string $listId
     * @param array $data
     * @return array
     */
    public function removeItemFromList(string $traktId, string $listId, array $data): array
    {
        return $this->client->post("users/{$traktId}/lists/{$listId}/items/remove", $data)->json();
    }

    /**
     * Reorder all items on a list by sending the updated rank of list item ids.
     * Use the /users/:id/lists/:list_id/items method to get all list item ids.
     *
     * https://trakt.docs.apiary.io/#reference/users/reorder-list-items/reorder-items-on-a-list
     * @param string $traktId
     * @param string $listId
     * @param array $data
     * @return array
     */
    public function reorderItemsOnList(string $traktId, string $listId, array $data): array
    {
        return $this->client->post("users/{$traktId}/lists/{$listId}/items/reorder", $data)->json();
    }

    /**
     * If the user has a private profile, the follow request will require approval (approved_at will be null).
     * If a user is public, they will be followed immediately (approved_at will have a date).
     * Note: If this user is already being followed, a 409 HTTP status code will returned.
     *
     * https://trakt.docs.apiary.io/#reference/users/follow/follow-this-user
     * @param string $traktId
     * @return array
     */
    public function follow(string $traktId): array
    {
        return $this->client->post("users/{$traktId}/follow")->json();
    }

    /**
     * If the user has a private profile, the follow request will require approval (approved_at will be null).
     * If a user is public, they will be followed immediately (approved_at will have a date).
     * Note: If this user is already being followed, a 409 HTTP status code will returned.
     *
     * https://trakt.docs.apiary.io/#reference/users/follow/unfollow-this-user
     * @param string $traktId
     * @return array
     */
    public function unfollow(string $traktId): array
    {
        return $this->client->delete("users/{$traktId}/follow")->json();
    }

    /**
     * Returns all followers including when the relationship began.
     *
     * https://trakt.docs.apiary.io/#reference/users/followers/get-followers
     * @param string $traktId
     * @return array
     */
    public function followers(
        string $traktId,
        bool $extended = false,
        ?string $level = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);

        return $this->client->get("users/{$traktId}/followers", $params)->json();
    }

    /**
     * Returns all user's they follow including when the relationship began.
     *
     * https://trakt.docs.apiary.io/#reference/users/following/get-following
     * @param string $traktId
     * @return array
     */
    public function following(
        string $traktId,
        bool $extended = false,
        ?string $level = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);

        return $this->client->get("users/{$traktId}/following", $params)->json();
    }

    /**
     * Returns all friends for a user including when the relationship began.
     * Friendship is a 2 way relationship where each user follows the other.
     *
     * https://trakt.docs.apiary.io/#reference/users/friends/get-friends
     * @param string $traktId
     * @return array
     */
    public function friends(
        string $traktId,
        bool $extended = false,
        ?string $level = null
    ): array
    {
        $params = $this->client->buildExtendedParams($extended, $level);

        return $this->client->get("users/{$traktId}/friends", $params)->json();
    }

    /**
     * Returns movies and episodes that a user has watched, sorted by most recent.
     * You can optionally limit the type to movies or episodes.
     * The id (64-bit integer) in each history item uniquely identifies the event and can be used
     * to remove individual events by using the /sync/history/remove method.
     * The action will be set to scrobble, checkin, or watch.Specify a type and trakt item_id to
     * limit the history for just that item. If the item_id is valid, but there is no history,
     * an empty array will be returned.
     *
     * https://trakt.docs.apiary.io/#reference/users/history/get-watched-history
     * @param string $traktId
     * @param string $type
     * @param int $itemId
     * @param string $startAt
     * @param string $endAt
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function history(
        string $traktId,
        string $type,
        int $itemId,
        string $startAt,
        string $endAt,
        int $page = 1,
        int $limit = 10,
        bool $extended = false,
        ?string $level = null
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));
        $params = array_merge($params, ['start_at' => $startAt, 'end_at' => $endAt]);

        return $this->client->get("users/{$traktId}/history/{$type}/{$itemId}", $params)->json();
    }

    /**
     * Get a user's ratings filtered by type.
     * You can optionally filter for a specific rating between 1 and 10.
     * Send a comma separated string for rating if you need multiple ratings.
     *
     * https://trakt.docs.apiary.io/#reference/users/ratings/get-ratings
     * @param string $traktId
     * @param string $type
     * @param ?int $rating
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function ratings(
        string $traktId,
        string $type,
        ?int $rating = null,
        int $page = 1,
        int $limit = 10,
        bool $extended = false,
        ?string $level = null
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));

        return $this->client->get("users/{$traktId}/ratings/{$type}/{$rating}", $params)->json();
    }

    /**
     * Returns all items in a user's watchlist filtered by type.
     *
     * https://trakt.docs.apiary.io/#reference/users/watchlist/get-watchlist
     * @param string $traktId
     * @param string $type
     * @param string $sort
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function watchlist(
        string $traktId,
        string $type,
        string $sortBy = 'rank',
        string $sortHow = 'asc',
        int $page = 1,
        int $limit = 10,
        bool $extended = false,
        ?string $level = null
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));

        return $this->client->get("users/{$traktId}/watchlist/{$type}/{$sortBy}/{$sortHow}", $params)->json();
    }

    /**
     * Returns the top 100 shows and movies a user has favorited. Apps should encourage user's to add favorites so the algorithm keeps getting better.
     *
     * https://trakt.docs.apiary.io/#reference/users/favorites/get-favorites
     * @param string $traktId
     * @param string $type
     * @param string $sort
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function favorites(
        string $traktId,
        string $type,
        string $sortBy = 'rank',
        string $sortHow = 'asc',
        int $page = 1,
        int $limit = 10,
        bool $extended = false,
        ?string $level = null
    ): array {
        $params = $this->client->buildPaginationParams($page, $limit);
        $params = array_merge($params, $this->client->buildExtendedParams($extended, $level));

        return $this->client->get("users/{$traktId}/favorites/{$type}/{$sortBy}/{$sortHow}", $params)->json();
    }

    /**
     * Returns a movie or episode if the user is currently watching something.
     * If they are not, it returns no data and a 204 HTTP status code.
     *
     * https://trakt.docs.apiary.io/#reference/users/watching/get-watching
     * @param string $traktId
     * @return array
     */
    public function watching(
        string $traktId,
        bool $extended = false,
        ?string $level = null
    ): array {
        $params = $this->client->buildExtendedParams($extended, $level);

        return $this->client->get("users/{$traktId}/watching", $params)->json();
    }

    /**
     * Returns all movies or shows a user has watched sorted by most plays.
     *
     * https://trakt.docs.apiary.io/#reference/users/watched/get-watched
     * @param string $traktId
     * @param string $type
     * @return array
     */
    public function watched(
        string $traktId,
        string $type,
        bool $extended = false,
        ?string $level = null
    ): array {
        $params = $this->client->buildExtendedParams($extended, $level);

        return $this->client->get("users/{$traktId}/watched/{$type}", $params)->json();
    }

    /**
     * Returns stats about the movies, shows, and episodes a user has watched, collected, and rated.
     *
     * https://trakt.docs.apiary.io/#reference/users/stats/get-stats
     * @param string $traktId
     * @return array
     */
    public function stats(string $traktId): array
    {
        return $this->client->get("users/{$traktId}/stats")->json();
    }
}
