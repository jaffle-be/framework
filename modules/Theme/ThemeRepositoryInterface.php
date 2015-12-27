<?php

namespace Modules\Theme;

/**
 * Interface ThemeRepositoryInterface
 * @package Modules\Theme
 */
interface ThemeRepositoryInterface
{
    public function supported();

    public function current();

    /**
     * @param $theme
     * @return mixed
     */
    public function activate($theme);
}
