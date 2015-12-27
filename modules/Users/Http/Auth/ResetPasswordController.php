<?php

namespace Modules\Users\Http\Auth;

use Illuminate\Contracts\Auth\Guard;
use Lang;
use Modules\System\Http\FrontController;
use Modules\Users\Auth\Commands\ResetPassword;
use Modules\Users\Auth\Requests\ResetPasswordRequest;
use Modules\Users\Auth\Tokens\TokenRepository;

class ResetPasswordController extends FrontController
{

    /**
     * Show the form for resetting the password.
     *
     * @return \Illuminate\View\View
     */
    public function show($token)
    {
        return $this->theme->render('auth.reset-password', compact('token'));
    }

    public function update($token, TokenRepository $tokens, ResetPasswordRequest $request, Guard $guard)
    {
        $token = $tokens->findTokenByValue($token);

        if ($token) {
            $user = $this->dispatch(new ResetPassword($request->get('email'), $token, $request->get('password'), $request->get('password_confirmation')));

            if ($user) {
                $guard->loginUsingId($user->id);

                return redirect('admin/start');
            }
        }

        //always redirect to signin if we get here.
        //the request was validated for correct input, so if the reset was no success,
        //we simply bail out for security reasons.
        return redirect()->to(store_route('store.auth.signin.index'))->withSuccess(Lang::get('users::front.request-handled'));
    }
}
