<?php namespace App\Account\Jobs\Membership;

use App\Account\Membership;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class RevokeMembership extends Job implements SelfHandling
{

    /**
     * @var Membership
     */
    protected $membership;

    public function __construct(Membership $membership)
    {
        $this->membership = $membership;
    }

    public function handle()
    {
        $account = $this->membership->account;
        $memberships = $account->memberships;

        //cannot revoke last membership or owner of the account
        if($memberships->count() == 1)
        {
            return false;
        }

        if($account->owner->id == $this->membership->member->id)
        {
            return false;
        }

        $this->membership->delete();
    }
}