<?php

namespace Modules\System\Scopes;

/**
 * Class ModelAccountResource
 * @package Modules\System\Scopes
 */
trait ModelAccountResource
{
    public static function bootModelAccountResource()
    {
        static::addGlobalScope(app()->make('Modules\System\Scopes\ModelAccountResourceScope'));
    }

    /**
     * @return mixed
     */
    public function account()
    {
        return $this->belongsTo('Modules\Account\Account');
    }
}
