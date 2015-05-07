<?php namespace App\Users\Contracts;

interface Throttler {

    public function allows($email);

    public function throttle($email);

    public function cooldown($ip, $email);

}