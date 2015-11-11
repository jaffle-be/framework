<?php namespace Modules\Users\Http\Auth;

use Lang;
use Modules\Account\AccountManager;
use Modules\System\Http\FrontController;
use Modules\Users\Auth\Commands\SendResetEmail;
use Modules\Users\Auth\Requests\ForgotPasswordRequest;

class ForgotPasswordController extends FrontController
{

    public function index()
    {
        return $this->theme->render('auth.forgot-password');
    }

    public function store(ForgotPasswordRequest $request, AccountManager $manager)
    {
        $this->dispatchFromArray(SendResetEmail::class, ['email' => $request->get('email'), 'manager' => $manager]);

        return redirect()->to(store_route('store.auth.signin.index'))->withSuccess(Lang::get('users::front.request-handled'));
    }
}