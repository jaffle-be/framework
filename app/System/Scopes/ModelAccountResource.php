<?php namespace App\System\Scopes;

trait ModelAccountResource
{
    public function account()
    {
        return $this->belongsTo('App\Account\Account');
    }

    public static function bootModelAccountResource()
    {
        static::addGlobalScope(app()->make('App\System\Scopes\ModelAccountResourceScope'));
    }

}