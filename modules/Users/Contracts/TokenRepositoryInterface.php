<?php

namespace Modules\Users\Contracts;

interface TokenRepositoryInterface
{
    public function createNewToken($type, $value, $expires = 2);

    public function findTokenByValue($value);
}
