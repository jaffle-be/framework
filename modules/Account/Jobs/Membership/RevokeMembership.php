<?php

namespace Modules\Account\Jobs\Membership;

use App\Jobs\Job;
use Modules\Account\Membership;

/**
 * Class RevokeMembership
 * @package Modules\Account\Jobs\Membership
 */
class RevokeMembership extends Job
{
    /**
     * @var Membership
     */
    protected $membership;

    /**
     * @param Membership $membership
     */
    public function __construct(Membership $membership)
    {
        $this->membership = $membership;
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function handle()
    {
        $account = $this->membership->account;
        $memberships = $account->memberships;

        //cannot revoke last membership or owner of the account
        if ($memberships->count() == 1) {
            return false;
        }

        if ($account->owner->id == $this->membership->member->id) {
            return false;
        }

        return $this->membership->delete();
    }
}
