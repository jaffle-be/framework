<?php

namespace Modules\Users\Auth\Throttler;

use App\Jobs\Job;
use Illuminate\Contracts\Queue\ShouldQueue;

class Cooldown extends Job implements ShouldQueue
{
    protected $ip;

    protected $email;

    public function __construct($ip, $email)
    {
        $this->ip = $ip;
        $this->email = $email;
    }

    public function handle(ThrottleManager $throttler)
    {
        $throttler->cooldown($this->ip, $this->email);
    }
}
