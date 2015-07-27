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
        //cannot revoke last membership or owner of the account
    }
}