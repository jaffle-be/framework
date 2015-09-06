<?php namespace App\Users\Auth\Commands;

use App\Jobs\Job;
use App\Users\Auth\Tokens\Token;
use App\Users\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;

class ConfirmEmail extends Job implements SelfHandling{

    protected $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    public function handle(UserRepositoryInterface $users, Guard $guard)
    {
        $user = $users->findUserByConfirmationToken($this->token->id);

        if($user)
        {
            if(!$user->confirmed)
            {
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