<?php namespace App\Settings;

trait Configurable
{

    public function settings()
    {
        return $this->morphMany('App\Settings\Setting', 'configurable');
    }

    public function settingValues()
    {

    }

}