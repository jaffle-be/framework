<?php

namespace Modules\System\Http\Middleware;

use Closure;

/**
 * Class HttpsProtocol
 * @package Modules\System\Http\Middleware
 */
class HttpsProtocol
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (! $request->secure() && env('APP_ENV') === 'production') {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
