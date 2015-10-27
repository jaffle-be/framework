<?php namespace Modules\System\Scopes;

trait FrontScoping
{

    public static function bootFrontScoping()
    {
        if(on_front())
        {
            $class = self::getFrontScopeName();

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