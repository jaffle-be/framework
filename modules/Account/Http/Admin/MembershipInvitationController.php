<?php namespace Modules\Account\Http\Admin;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Modules\Account\AccountManager;
use Modules\Account\MembershipInvitation;
use Modules\System\Http\AdminController;
use Modules\Theme\ThemeMailer;

class MembershipInvitationController extends AdminController
{

    public function index(MembershipInvitation $invitation)
    {
        return MembershipInvitation::orderBy('created_at', 'asc')->get();
    }

    public function store(Request $request, AccountManager $manager, ThemeMailer $mailer, Hasher $hasher, Translator $lang)
    {
        $this->validate($request, ['email' => 'required|email']);

        $hash = $this->getNewHash($request, $hasher);

        $account = $manager->account();

        $invitation = new MembershipInvitation([
            'email' => $request->get('email'),
            'token' => $hash,
        ]);

        $account->membershipInvitations()->save($invitation);

        $mailer->send('account::admin.members.invitation.email', ['invitation' => $invitation], function ($message) use ($invitation, $account, $lang) {
            $message->to($invitation->email);
            $message->from($account->contactInformation->first()->email);
            $message->subject($lang->get('account::admin.users.you-are-invited'));
        });

        return $invitation;
    }

    public function destroy($invitation, Request $request, AccountManager $manager)
    {
        $account = $manager->account();

        if ($account->membershipInvitations->contains($invitation)) {
            $invitation = $account->membershipInvitations->find($invitation);

            if($invitation->delete())
            {
                $invitation->id = false;
            }
        }

        return $invitation;
    }

    /**
     * @param Request $request
     * @param Hasher  $hasher
     *
     * @return array
     */
    protected function getNewHash(Request $request, Hasher $hasher)
    {
        $email = $request->get('email');
        $hash = $hasher->make(time() . 'someRandome123string' . $email);
        $hash = str_replace('/', '_', $hash);

        return $hash;
    }

}