<?php namespace App\Settings;

class CachedSettingsRepository
{

    public function __construct(SettingsRepository $repository)
    {
        $this->repo = $repository;
    }

    function __call($name, $arguments)
    {
        if(method_exists($this->repo, $arguments))
        {
            return call_user_func_array(array($this, $name), $arguments);
        }
    }
}