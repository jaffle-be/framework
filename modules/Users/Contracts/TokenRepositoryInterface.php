<?php

namespace Modules\Users\Contracts;

/**
 * Interface TokenRepositoryInterface
 * @package Modules\Users\Contracts
 */
interface TokenRepositoryInterface
{
    /**
     * @param $type
     * @param $value
     * @param int $expires
     * @return mixed
     */
    public function createNewToken($type, $value, $expires = 2);

    /**
     * @param $value
     * @return mixed
     */
    public function findTokenByValue($value);
}
