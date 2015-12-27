<?php

namespace Modules\Account\Jobs\Membership;

use App\Jobs\Job;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\MembershipInvitation;
use Modules\Account\MembershipOwner;

/**
 * Class AcceptMembership
 * @package Modules\Account\Jobs\Membership
 */
class AcceptMembership extends Job
{
    use DispatchesJobs;

    protected $invitation;

    protected $member;

    /**
     * @param MembershipInvitation $invitation
     * @param MembershipOwner $member
     */
    public function __construct(MembershipInvitation $invitation, MembershipOwner $member)
    {
        $this->invitation = $invitation;
        $this->member = $member;
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function handle()
    {
        $account = $this->invitation->account;

        if ($this->dispatch(new NewMembership($account, $this->member))
        ) {
            return $this->invitation->delete();
        }

        return false;
    }
}
