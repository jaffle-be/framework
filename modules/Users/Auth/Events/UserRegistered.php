<?php namespace Modules\Users\Auth\Events;

use App\Events\Event;
use Modules\Account\MembershipInvitation;
use Modules\Users\User;

class UserRegistered extends Event
{

    public $user;

    public $invitation;

    public function __construct(User $user, MembershipInvitation $invitation = null)
    {
        $this->user = $user;
        $this->invitation = $invitation;
    }

}