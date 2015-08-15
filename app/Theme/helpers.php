<?php

if(!defined('theme_asset'))
{
    function theme_asset($asset)
    {
        return app('App\Theme\Theme')->asset($asset);
    }
}