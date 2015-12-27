<?php

namespace Modules\Users;

use Modules\Users\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @var User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User|null
     */
    public function findUserByConfirmationToken($token)
    {
        return $this->user->newQuery()->where('confirmation_token_id', $token)->first();
    }

    public function findUserByEmail($email)
    {
        return $this->user->newQuery()->where('email', $email)->first();
    }
}
