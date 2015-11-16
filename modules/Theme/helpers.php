<?php

if (!function_exists('theme_asset')) {
    function theme_asset($asset)
    {
        return app('Modules\Theme\Theme')->asset($asset);
    }
}