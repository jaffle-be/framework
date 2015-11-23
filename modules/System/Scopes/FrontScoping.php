<?php namespace Modules\System\Scopes;

trait FrontScoping
{

    public static function bootFrontScoping()
    {
        $class = self::getFrontScopeName();

        if (on_front()) {
            static::addGlobalScope(new $class());
        }
        else{
            //added this for tests
            $className = get_class(new static);

            if(isset(static::$globalScopes[$className]))
            {
                $classScopes = static::$globalScopes[$className];

                static::$globalScopes[$className] = array_except($classScopes, $class);;
            }
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