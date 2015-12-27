<?php

namespace Modules\Theme\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Theme
 * @package Modules\Theme\Facade
 */
class Theme extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'theme';
    }
}
