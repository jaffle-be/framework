<?php

namespace App\Account\Http\Middleware;

use App\Account\AccountManager;
use Closure;
use Illuminate\Http\Request;

class AccountMiddleware {

    protected $manager;

    public function __construct(AccountManager $manager)
    {
        $this->manager = $manager;
    }

    public function handle(Request $request, Closure $next)
    {
        $account = $this->manager->boot($request);

        if(!$account)
        {
            return response('Invalid account provided', 403);
        }

        return $next($request);
    }

}