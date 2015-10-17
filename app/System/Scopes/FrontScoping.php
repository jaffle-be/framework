<?php namespace App\System\Scopes;

use Illuminate\Http\Request;

trait FrontScoping
{

    public static function bootFrontScoping()
    {
        /** @var Request $request */
        $request = app('request');

        if(app()->runningInConsole())
        {
            return;
        }

        $class = self::getFrontScopeName();

        if(!starts_with($request->getRequestUri(), ['/admin', '/api']))
        {
            static::addGlobalScope(new $class());
        }
    }

    /**
     * @return mixed|string
     */
    protected static function getFrontScopeName()
    {
        return __CLASS__ . 'ScopeFront';
    }

}