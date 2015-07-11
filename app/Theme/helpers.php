<?php

if(!defined('theme_asset'))
{
    function theme_asset($asset)
    {
        return app('theme')->asset($asset);
    }
}