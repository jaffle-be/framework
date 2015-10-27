<?php namespace Modules\Account;

class MembershipRepository
{

    /**
     * @var Membership
     */
    protected $membership;

    /**
     * @var MembershipInvitation
     */
    protected $invitation;

    /**
     * @var AccountManager
     */
    protected $manager;

    public function __construct(Membership $membership, MembershipInvitation $invitation, AccountManager $manager)
    {
        $this->membership = $membership;
        $this->invitation = $invitation;
        $this->manager = $manager;
    }

    public function findInvitationByToken($token)
    {
        $account = $this->manager->account();

        return $this->invitation
            ->where('account_id', $account->id)
            ->where('token', $token)
            ->first();
    }

}