<?php

namespace Modules\Account\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Account\AccountManager;

/**
 * Class AccountMiddleware
 * @package Modules\Account\Http\Middleware
 */
class AccountMiddleware
{
    protected $manager;

    /**
     * @param AccountManager $manager
     */
    public function __construct(AccountManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Request $request
     * @param Closure $next
     */
    public function handle(Request $request, Closure $next)
    {
        $account = $this->manager->boot($request);

        if (! $account) {
            return abort(403, 'Invalid account provided');
        }

        return $next($request);
    }
}
