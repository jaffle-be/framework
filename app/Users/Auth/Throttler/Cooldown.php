<?php namespace App\Users\Auth\Throttler;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class Cooldown extends Job implements ShouldBeQueued, SelfHandling{

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