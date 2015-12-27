<?php

namespace Modules\Users\Contracts;

/**
 * Interface UserRepositoryInterface
 * @package Modules\Users\Contracts
 */
interface UserRepositoryInterface
{
    /**
     * @param $token
     * @return
     */
    public function findUserByConfirmationToken($token);

    /**
     * @param $email
     * @return mixed
     */
    public function findUserByEmail($email);
}
