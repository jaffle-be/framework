<?php namespace App\Account\Commands;

use App\Account\Account;
use App\Account\AccountRepositoryInterface;
use App\Account\MembershipOwner;
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
    protected $owner;

    public function __construct(Account $account, MembershipOwner $owner)
    {
        $this->account = $account;
        $this->owner = $owner;
    }

    public function handle()
    {
        $this->account->members()->associate($this->owner);
    }

}