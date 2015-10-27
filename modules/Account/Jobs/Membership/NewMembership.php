<?php namespace Modules\Account\Jobs\Membership;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Account\Account;
use Modules\Account\Membership;
use Modules\Account\MembershipOwner;

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