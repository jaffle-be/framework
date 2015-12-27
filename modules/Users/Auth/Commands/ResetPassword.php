<?php

namespace Modules\Users\Auth\Commands;

use App\Jobs\Job;
use Illuminate\Contracts\Hashing\Hasher;
use Modules\Users\Auth\Tokens\Token;
use Modules\Users\Contracts\UserRepositoryInterface;
use Modules\Users\User;

class ResetPassword extends Job
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var Token
     */
    protected $token;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $password_confirmation;

    /**
     * Create a new command instance.
     *
     * @param       $email
     * @param Token $token
     * @param       $password
     * @param       $password_confirmation
     */
    public function __construct($email, Token $token, $password, $password_confirmation)
    {
        $this->email = $email;
        $this->token = $token;
        $this->password = $password;
        $this->password_confirmation = $password_confirmation;
    }

    /**
     * @param UserRepositoryInterface $users
     * @param Hasher                  $hasher
     *
     * @return string
     */
    public function handle(UserRepositoryInterface $users, hasher $hasher)
    {
        $user = $users->findUserByEmail($this->email);

        if ($user) {
            if (!$this->validToken($user)) {
                return 'invalid token';
            }

            if ($this->equalPasswords()) {
                $user->password = $hasher->make($this->password);

                $user->reset_token_id = null;

                $user->save();

                $this->token->delete();

                return $user;
            }
        }
    }

    /**
     * @param $user
     *
     * @return bool
     */
    protected function validToken(User $user)
    {
        return $this->token->value == $user->resetToken->value;
    }

    /**
     * @return string
     */
    protected function equalPasswords()
    {
        return $this->password = $this->password_confirmation;
    }
}
