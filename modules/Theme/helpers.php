<?php

if(!defined('theme_asset'))
{
    function theme_asset($asset)
    {
        return app('Modules\Theme\Theme')->asset($asset);
    }
}