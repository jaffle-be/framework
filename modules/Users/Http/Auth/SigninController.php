<?php

namespace Modules\Users\Http\Auth;

use Illuminate\Translation\Translator;
use Modules\System\Http\FrontController;
use Modules\Users\Auth\Commands\Signin;
use Modules\Users\Auth\Requests\SigninRequest;
use Modules\Users\User;

/**
 * Class SigninController
 * @package Modules\Users\Http\Auth
 */
class SigninController extends FrontController
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->theme->render('auth.login');
    }

    /**
     * @param SigninRequest $request
     * @param Translator $lang
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SignInRequest $request, Translator $lang)
    {
        $credentials = $request->except('_token', 'remember_me');

        $remember_me = $request->has('remember_me') ? true : false;

        $response = $this->dispatch(new Signin($credentials, $remember_me));

        if ($response instanceof User) {
            return redirect('admin/start');
        } elseif (is_string($response) && $response == 'unconfirmed') {
            $route = store_route('store.auth.confirm-email.create', ['email' => $credentials['email']]);

            $error = $lang->get('users::auth.errors.unconfirmed', ['url' => $route]);

            return redirect()->back()->withErrors(['email' => $error]);
        }

        return redirect()->back()->withErrors(['email' => $lang->get('users::auth.errors.failed')]);
    }
}
