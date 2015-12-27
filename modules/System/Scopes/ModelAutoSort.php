<?php

namespace Modules\System\Scopes;

/**
 * Class ModelAutoSort
 * @package Modules\System\Scopes
 */
trait ModelAutoSort
{
    public static function bootModelAutoSort()
    {
        static::addGlobalScope(new ModelAutoSortScope());
    }
}
