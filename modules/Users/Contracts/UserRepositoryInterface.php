<?php

namespace Modules\Users\Contracts;

interface UserRepositoryInterface
{
    /**
     *
     *
     * @return User|null
     */
    public function findUserByConfirmationToken($token);

    public function findUserByEmail($email);
}
