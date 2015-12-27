<?php

namespace Modules\System\Scopes;

trait FrontScoping
{
    public static function bootFrontScoping()
    {
        $class = __CLASS__.'ScopeFront';

        if (on_front()) {
            static::addGlobalScope(new $class());
        }
    }
}
