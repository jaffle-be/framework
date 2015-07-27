<?php namespace App\Users\Auth\Events;

use App\Account\MembershipInvitation;
use App\Events\Event;
use App\Users\User;

class UserRegistered extends Event{

    public $user;

    public $invitation;

    public function __construct(User $user, MembershipInvitation $invitation = null)
    {
        $this->user = $user;
        $this->invitation = $invitation;
    }

}