<?php

namespace Modules\Users\Http\Auth;

use Illuminate\Auth\Guard;
use Modules\Account\MembershipInvitation;
use Modules\System\Http\FrontController;
use Modules\Users\Auth\Commands\Signup;
use Modules\Users\Auth\Requests\SignupRequest;
use Modules\Users\User;

class SignupController extends FrontController
{
    public function index()
    {
        $user = new User();

        return $this->theme->render('auth.register', compact('user'));
    }

    public function store(SignupRequest $request, Guard $guard)
    {
        $data = $request->only(['email', 'password']);

        $invitation = null;

        if ($request->has('invitation')) {
            $invitation = MembershipInvitation::find($request->get('invitation'));

            if (! $invitation) {
                return redirect()->back()->with('message', 'failed');
            }
        }

        if ($user = $this->dispatch(new Signup($request->get('email'), $request->get('password'), $invitation))) {
            if ($user->confirmed) {
                //user can be logged in too
                $guard->login($user);

                return redirect()->to(store_route('store.dash'));
            }

            return redirect()->to(store_route('store.home'))->with('message', 'success');
        }

        return redirect()->back()->with('message', 'failed');
    }
}
