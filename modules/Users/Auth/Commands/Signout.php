<?php

namespace Modules\Users\Auth\Commands;

use App\Jobs\Job;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class Signout
 * @package Modules\Users\Auth\Commands
 */
class Signout extends Job
{
    /**
     * @param Guard $guard
     */
    public function handle(Guard $guard)
    {
        $guard->logout();
    }
}
