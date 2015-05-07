<?php namespace App\Users\Auth\Commands;

use App\Commands\Command;
use App\Users\Contracts\UserRepositoryInterface;
use App\Users\Auth\Tokens\Token;
use Illuminate\Contracts\Bus\SelfHandling;

class ConfirmEmail extends Command implements SelfHandling{

    protected $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    public function handle(UserRepositoryInterface $users)
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
        }

        //token can always be deleted
        $this->token->delete();
    }

}