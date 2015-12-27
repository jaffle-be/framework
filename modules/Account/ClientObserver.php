<?php

namespace Modules\Account;

/**
 * Class ClientObserver
 * @package Modules\Account
 */
class ClientObserver
{
    /**
     * @param Client $client
     */
    public function deleting(Client $client)
    {
        if ($client->images) {
            $client->images->delete();
        }
    }
}
