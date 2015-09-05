<?php namespace App\Users\Http\Auth;

use App\Account\AccountManager;
use App\System\Http\Controller;
use App\Users\Auth\Commands\ConfirmEmail;
use App\Users\Auth\Commands\SendConfirmationEmail;
use App\Users\Contracts\TokenRepositoryInterface;
use App\Users\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Lang;

class ConfirmEmailController extends Controller
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

        return redirect()->route('store.auth.signin.index')->withSuccess(Lang::get('users::front.request-handled'));
    }

    /**
     * The method which actually triggers the confirmation
     *
     * @param                          $token
     * @param TokenRepositoryInterface $tokens
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($token, TokenRepositoryInterface $tokens)
    {
        $token = $tokens->findTokenByValue($token);

        if ($token) {
            $this->dispatchFromArray(ConfirmEmail::class, ['token' => $token]);
        }

        return redirect()->route('store.home');
    }
}
