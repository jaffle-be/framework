<?php namespace App\Account\Http;

use App\Account\MembershipRepository;
use App\System\Http\Controller;
use App\Users\Auth\Commands\Signup;
use App\Users\User;
use Illuminate\Contracts\Auth\Guard;

class MembershipInvitationController extends Controller
{

    public function show(MembershipRepository $repository, $invitation, Guard $guard)
    {
        $invitation = $repository->findInvitationByToken($invitation);

        if(!$invitation)
        {
            return redirect()->route('store.home');
        }

        //do we have an invitation for a user with a registered account?
        //if so, we simply accept it instead of asking for credentials.
        if($user = User::where('email', $invitation->email)->limit(1)->first())
        {
            $user = $this->dispatchFromArray(Signup::class, ['email' => false, 'password' => false, 'user' => $user, 'invitation' => $invitation]);

            if($user->confirmed)
            {
                //user can be logged in too
                $guard->login($user);

                return redirect()->route('store.dash');
            }

            return redirect()->route('store.home')->with('message', 'success');
        }

        return $this->theme->render('auth.register', ['invitation' => $invitation]);
    }
}