<?php

namespace Modules\Users;

use Modules\Users\Contracts\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package Modules\Users
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $token
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findUserByConfirmationToken($token)
    {
        return $this->user->newQuery()->where('confirmation_token_id', $token)->first();
    }

    /**
     * @param $email
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findUserByEmail($email)
    {
        return $this->user->newQuery()->where('email', $email)->first();
    }
}
