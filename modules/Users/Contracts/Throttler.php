<?php

namespace Modules\Users\Contracts;

/**
 * Interface Throttler
 * @package Modules\Users\Contracts
 */
interface Throttler
{
    /**
     * @param $email
     * @return mixed
     */
    public function allows($email);

    /**
     * @param $email
     * @return mixed
     */
    public function throttle($email);

    /**
     * @param $ip
     * @param $email
     * @return mixed
     */
    public function cooldown($ip, $email);
}
