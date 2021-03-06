<?php

namespace Modules\Account\Http;

use Illuminate\Contracts\Auth\Guard;
use Modules\Account\MembershipRepository;
use Modules\System\Http\FrontController;
use Modules\Users\Auth\Commands\Signup;
use Modules\Users\User;

/**
 * Class MembershipInvitationController
 * @package Modules\Account\Http
 */
class MembershipInvitationController extends FrontController
{
    /**
     * @param MembershipRepository $repository
     * @param $invitation
     * @param Guard $guard
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(MembershipRepository $repository, $invitation, Guard $guard)
    {
        $invitation = $repository->findInvitationByToken($invitation);

        if (! $invitation) {
            return redirect()->to(store_route('store.home'));
        }

        //do we have an invitation for a user with a registered account?
        //if so, we simply accept it instead of asking for credentials.
        if ($user = User::where('email', $invitation->email)->limit(1)->first()) {
            $user = $this->dispatch(new Signup(false, false, $invitation));

            if ($user->confirmed) {
                //user can be logged in too
                $guard->login($user);

                return redirect()->to(store_route('store.dash'));
            }

            return redirect()->to(store_route('store.home'))->with('message', 'success');
        }

        return $this->theme->render('auth.register', ['invitation' => $invitation]);
    }
}
