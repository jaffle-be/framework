<?php

if (! function_exists('theme_asset')) {
    /**
     * @param $asset
     * @return mixed
     */
    function theme_asset($asset)
    {
        return app('Modules\Theme\Theme')->asset($asset);
    }
}
