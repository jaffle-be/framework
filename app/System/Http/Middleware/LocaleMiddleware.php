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
        //on the front, locale is determined by either:
        // - multi locale -> url prefix
        // - single locale -> from config

        if (on_front()) {
            $request = app('request');

            if (env('APP_MULTIPLE_LOCALES')) {
                //if valid locale
                $locale = $request->segment(1);

                app()->setLocale($locale);
            }
        } elseif ($this->session->has('locale')) {
            app()->setLocale($this->session->get('locale'));
        }

        return $next($request);
    }
}