<?php

namespace Modules\Account\Jobs\Membership;

use App\Jobs\Job;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\MembershipInvitation;
use Modules\Account\MembershipOwner;

class AcceptMembership extends Job
{

    use DispatchesJobs;

    protected $invitation;

    protected $member;

    public function __construct(MembershipInvitation $invitation, MembershipOwner $member)
    {
        $this->invitation = $invitation;
        $this->member = $member;
    }

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
