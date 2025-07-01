<?php

namespace Pvguerra\LaravelTrakt;

use Pvguerra\LaravelTrakt\Contracts\ClientInterface;

class TraktCheckIn
{

    public function __construct(protected ClientInterface $client)
    {
    }
    /**
     * Check into a movie or episode. This should be tied to a user action to manually
     * indicate they are watching something. The item will display as watching on the site,
     * then automatically switch to watched status once the duration has elapsed.
     *
     * https://trakt.docs.apiary.io/#reference/checkin/checkin/check-into-an-item
     * @param array $data
     * @return array
     */
    public function checkIn(array $data): array
    {
        return $this->client->post("checkin", $data)->json();
    }

    /**
     * Removes any active checkins, no need to provide a specific item.
     *
     * https://trakt.docs.apiary.io/#reference/checkin/checkin/delete-any-active-checkins
     * @return array
     */
    public function deleteCheckIns(): array
    {
        return $this->client->delete("checkin")->json();
    }
}
