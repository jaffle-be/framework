<?php namespace App\System\Scopes;

trait ModelAccountResource
{

    public static function bootModelAccountResource()
    {
        static::addGlobalScope(app()->make('App\System\Scopes\ModelAccountResourceScope'));
    }

}