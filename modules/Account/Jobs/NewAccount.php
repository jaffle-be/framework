<?php namespace Modules\Account\Jobs;

use App\Jobs\Job;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\AccountRepository;
use Modules\Account\Jobs\Membership\NewMembership;
use Modules\Account\MembershipOwner;

class NewAccount extends Job
{

    use DispatchesJobs;

    /**
     * @var MembershipOwner
     */
    protected $owner;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var string
     */
    protected $alias;

    public function __construct($domain, $alias, MembershipOwner $owner)
    {
        $this->domain = $domain;
        $this->alias = $alias;
        $this->owner = $owner;
    }

    public function handle(AccountRepository $repo)
    {
        //create the new account
        $account = $repo->newAccount([
            'alias'   => $this->alias,
            'domain'  => $this->domain,
            'user_id' => $this->owner->getKey()
        ]);

        if (!$account) {
            return false;
        }

        //setup the membership link
        $linked = $this->dispatch(new NewMembership($account, $this->owner));

        if (!$linked) {
            return false;
        }
    }

}