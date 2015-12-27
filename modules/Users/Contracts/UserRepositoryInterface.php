<?php

namespace Modules\Users\Contracts;

interface UserRepositoryInterface
{
    /**
     * @param $token
     *
     * @return User|null
     */
    public function findUserByConfirmationToken($token);

    public function findUserByEmail($email);
}
