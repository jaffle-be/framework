<?php namespace App\Account;

class ClientObserver
{

    public function deleting(Client $client)
    {
        if($client->images)
        {
            $client->images->delete();
        }
    }

}