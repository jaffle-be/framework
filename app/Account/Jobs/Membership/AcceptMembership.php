<?php namespace App\Account\Jobs\Membership;

use App\Account\MembershipInvitation;
use App\Account\MembershipOwner;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

class AcceptMembership extends Job implements SelfHandling
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

        if($this->dispatchFromArray(NewMembership::class, [
            'account' => $account,
            'member' => $this->member
        ]))
        {
            return $this->invitation->delete();
        }

        return false;
    }

}