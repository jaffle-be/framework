<?php namespace App\Account\Jobs\Membership;

use App\Account\Account;
use App\Account\Membership;
use App\Account\MembershipOwner;
use App\Account\Role;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class NewMembership extends Job implements SelfHandling{

    /**
     * @var Account
     */
    protected $account;

    /**
     * @var MembershipOwner
     */
    protected $member;

    public function __construct(Account $account, MembershipOwner $member)
    {
        $this->account = $account;
        $this->member = $member;
    }

    public function handle()
    {
        $membership = new Membership();
        $membership->member()->associate($this->member);

        return $this->account->memberships()->save($membership);
    }

}