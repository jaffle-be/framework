<?php namespace App\Users\Http\Auth;

use App\Account\AccountManager;
use App\System\Http\Controller;
use App\Users\Auth\Commands\SendResetEmail;
use App\Users\Auth\Requests\ForgotPasswordRequest;
use Lang;

class ForgotPasswordController extends Controller
{

    public function index()
    {
        return $this->theme->render('auth.forgot-password');
    }

    public function store(ForgotPasswordRequest $request, AccountManager $manager)
    {
        $this->dispatchFromArray(SendResetEmail::class, ['email' => $request->get('email'), 'manager' => $manager]);

        return redirect()->route('store.auth.signin.index')->withSuccess(Lang::get('users::front.request-handled'));
    }
}