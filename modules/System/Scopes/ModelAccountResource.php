<?php namespace Modules\System\Scopes;

trait ModelAccountResource
{

    public static function bootModelAccountResource()
    {
        static::addGlobalScope(app()->make('Modules\System\Scopes\ModelAccountResourceScope'));
    }

    public function account()
    {
        return $this->belongsTo('Modules\Account\Account');
    }

}