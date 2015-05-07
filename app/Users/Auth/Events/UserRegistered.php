<?php namespace App\Users\Auth\Events;

use App\Events\Event;
use App\Users\User;

class UserRegistered extends Event{

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

}