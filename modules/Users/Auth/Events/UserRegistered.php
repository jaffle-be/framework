<?php

namespace Modules\Users\Auth\Events;

use App\Events\Event;
use Modules\Account\MembershipInvitation;
use Modules\Users\User;

/**
 * Class UserRegistered
 * @package Modules\Users\Auth\Events
 */
class UserRegistered extends Event
{
    public $user;

    public $invitation;

    /**
     * @param User $user
     * @param MembershipInvitation|null $invitation
     */
    public function __construct(User $user, MembershipInvitation $invitation = null)
    {
        $this->user = $user;
        $this->invitation = $invitation;
    }
}
