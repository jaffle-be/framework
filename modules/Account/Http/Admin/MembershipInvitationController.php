<?php

namespace Modules\Account\Http\Admin;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Account\Jobs\Membership\SendInvitationEmail;
use Modules\Account\MembershipInvitation;
use Modules\System\Http\AdminController;

/**
 * Class MembershipInvitationController
 * @package Modules\Account\Http\Admin
 */
class MembershipInvitationController extends AdminController
{
    use DispatchesJobs;

    /**
     * @param MembershipInvitation $invitation
     * @return mixed
     */
    public function index(MembershipInvitation $invitation)
    {
        return MembershipInvitation::orderBy('created_at', 'asc')->get();
    }

    /**
     * @param Request $request
     * @param AccountManager $manager
     * @param Hasher $hasher
     * @return MembershipInvitation
     */
    public function store(Request $request, AccountManager $manager, Hasher $hasher)
    {
        $this->validate($request, ['email' => 'required|email']);

        $hash = $this->getNewHash($request, $hasher);

        $account = $manager->account();

        $invitation = new MembershipInvitation([
            'email' => $request->get('email'),
            'token' => $hash,
        ]);

        $account->membershipInvitations()->save($invitation);

        $this->dispatch(new SendInvitationEmail($invitation));

        return $invitation;
    }

    /**
     * @param $invitation
     * @param Request $request
     * @param AccountManager $manager
     * @return mixed
     */
    public function destroy($invitation, Request $request, AccountManager $manager)
    {
        $account = $manager->account();

        if ($account->membershipInvitations->contains($invitation)) {
            $invitation = $account->membershipInvitations->find($invitation);

            if ($invitation->delete()) {
                $invitation->id = false;
            }
        }

        return $invitation;
    }

    /**
     * @param Request $request
     * @param Hasher $hasher
     * @return mixed|string
     */
    protected function getNewHash(Request $request, Hasher $hasher)
    {
        $email = $request->get('email');
        $hash = $hasher->make(time().'someRandome123string'.$email);
        $hash = str_replace('/', '_', $hash);

        return $hash;
    }
}
