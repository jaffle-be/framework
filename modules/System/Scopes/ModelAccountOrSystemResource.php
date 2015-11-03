<?php namespace Modules\System\Scopes;

trait ModelAccountOrSystemResource
{
    public function account()
    {
        return $this->belongsTo('Modules\Account\Account');
    }

    public static function bootModelAccountOrSystemResource()
    {
        static::addGlobalScope(app()->make('Modules\System\Scopes\ModelAccountOrSystemResourceScope'));
    }

}