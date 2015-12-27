<?php

namespace Modules\Users\Auth\Throttler;

use App\Jobs\Job;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class Cooldown
 * @package Modules\Users\Auth\Throttler
 */
class Cooldown extends Job implements ShouldQueue
{
    protected $ip;

    protected $email;

    /**
     * @param $ip
     * @param $email
     */
    public function __construct($ip, $email)
    {
        $this->ip = $ip;
        $this->email = $email;
    }

    /**
     * @param ThrottleManager $throttler
     */
    public function handle(ThrottleManager $throttler)
    {
        $throttler->cooldown($this->ip, $this->email);
    }
}
