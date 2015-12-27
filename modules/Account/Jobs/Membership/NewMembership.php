<?php

namespace Modules\Account\Jobs\Membership;

use App\Jobs\Job;
use Modules\Account\Account;
use Modules\Account\Membership;
use Modules\Account\MembershipOwner;

/**
 * Class NewMembership
 * @package Modules\Account\Jobs\Membership
 */
class NewMembership extends Job
{
    /**
     * @var Account
     */
    protected $account;

    /**
     * @var MembershipOwner
     */
    protected $member;

    /**
     * @param Account $account
     * @param MembershipOwner $member
     */
    public function __construct(Account $account, MembershipOwner $member)
    {
        $this->account = $account;
        $this->member = $member;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handle()
    {
        $membership = new Membership();
        $membership->member()->associate($this->member);

        return $this->account->memberships()->save($membership);
    }
}
