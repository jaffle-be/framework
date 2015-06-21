<?php namespace App\Account\Commands;

use App\Account\AccountRepositoryInterface;
use App\Account\MembershipOwner;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class NewAccount extends Job implements SelfHandling{

    /**
     * @var MembershipOwner
     */
    protected $user;

    /**
     * @var array
     */
    protected $payload;

    public function __construct(MembershipOwner $user, $payload)
    {
        $this->user = $user;

        $this->payload = $payload;
    }

    public function handle(AccountRepositoryInterface $repo)
    {
        //create the new account
        $account = $repo->newAccount(array_merge($this->payload, ['owner_id' => $this->user->getKey()]));

        if(!$account)
        {
            return false;
        }

        //setup the membership link
        $linked = $this->dispatchFrom(NewMembership($account, $user));

        if(!$linked)
        {

        }
    }

}