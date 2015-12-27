<?php

namespace Modules\Users\Auth\Commands;

use App\Jobs\Job;
use Illuminate\Contracts\Auth\Guard;
use Modules\Users\Auth\Tokens\Token;
use Modules\Users\Contracts\UserRepositoryInterface;

/**
 * Class ConfirmEmail
 * @package Modules\Users\Auth\Commands
 */
class ConfirmEmail extends Job
{
    protected $token;

    /**
     * @param Token $token
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    /**
     * @param UserRepositoryInterface $users
     * @param Guard $guard
     * @return mixed
     * @throws \Exception
     */
    public function handle(UserRepositoryInterface $users, Guard $guard)
    {
        $user = $users->findUserByConfirmationToken($this->token->id);

        if ($user) {
            if (! $user->confirmed) {
                $user->confirmed = 1;
            }

            //only reset the token if we actually found a user
            $user->confirmation_token_id = null;

            $user->save();

            $guard->loginUsingId($user->id);
        }

        //token can always be deleted
        $this->token->delete();

        return $user;
    }
}
