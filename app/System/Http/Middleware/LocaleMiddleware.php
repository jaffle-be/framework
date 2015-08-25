<?php namespace App\System\Http\Middleware;

use Closure;
use Illuminate\Session\Store;

class LocaleMiddleware
{

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->session->has('locale'))
        {
            app()->setLocale($this->session->get('locale'));
        }

        return $next($request);
    }
}