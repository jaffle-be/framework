<?php namespace App\Users\Http\Auth;

use App\System\Http\Controller;
use App\Users\Auth\Commands\ResetPassword;
use App\Users\Auth\Requests\ResetPasswordRequest;
use App\Users\Auth\Tokens\TokenRepository;
use Illuminate\Contracts\Auth\Guard;
use Lang;

class ResetPasswordController extends Controller
{

    /**
     * Show the form for resetting the password
     *
     * @param $token
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
            $user = $this->dispatchFrom(ResetPassword::class, $request, ['token' => $token]);

            if ($user) {
                $guard->loginUsingId($user->id);

                return redirect()->route('store.dash');
            }
        }

        //always redirect to signin if we get here.
        //the request was validated for correct input, so if the reset was no success,
        //we simply bail out for security reasons.
        return redirect()->route('store.auth.signin.index')->withSuccess(Lang::get('users::general.request-handled'));
    }
}