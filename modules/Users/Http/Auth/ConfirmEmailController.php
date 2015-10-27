<?php namespace Modules\Users\Http\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Lang;
use Modules\Account\AccountManager;
use Modules\System\Http\FrontController;
use Modules\Users\Auth\Commands\ConfirmEmail;
use Modules\Users\Auth\Commands\SendConfirmationEmail;
use Modules\Users\Contracts\TokenRepositoryInterface;
use Modules\Users\Contracts\UserRepositoryInterface;

class ConfirmEmailController extends FrontController
{

    /**
     * Form for sending new confirmation email.
     *
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $email = $request->get('email', false);

        return $this->theme->render('auth.request-confirmation-email', ['email' => $email]);
    }

    /**
     * Trigger the actual sending of the email.
     *
     * @param Request                 $request
     * @param UserRepositoryInterface $users
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, UserRepositoryInterface $users, AccountManager $manager)
    {
        $user = $users->findUserByEmail($request->get('email'));

        if ($user) {
            $this->dispatchFromArray(SendConfirmationEmail::class, ['user' => $user, 'manager' => $manager]);
        }

        return redirect()->to(store_route('store.auth.signin.index'))->withSuccess(Lang::get('users::front.request-handled'));
    }

    /**
     * The method which actually triggers the confirmation
     *
     * @param                          $token
     * @param TokenRepositoryInterface $tokens
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($token, TokenRepositoryInterface $tokens, Guard $guard)
    {
        $token = $tokens->findTokenByValue($token);

        if ($token) {
            $user = $this->dispatchFromArray(ConfirmEmail::class, ['token' => $token]);

            if($user)
            {
                return redirect('admin/start');
            }
        }

        return redirect()->to(store_route('store.home'));
    }
}
