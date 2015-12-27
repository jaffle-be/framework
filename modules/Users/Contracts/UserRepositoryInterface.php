<?php

namespace Modules\Users\Contracts;

interface UserRepositoryInterface
{
    /**
     *
     */
    public function findUserByConfirmationToken($token);

    public function findUserByEmail($email);
}
