<?php

namespace App\Theme\Contracts;

interface Theme
{

    /**
     * Set the name for the theme to use
     *
     * @param $name
     * @return string
     */
    public function name($name = null);

    /**
     * Render a theme view
     *
     * @param $view
     * @param $data
     * @return mixed
     */
    public function render($view, array $data = []);

    /**
     * Return an asset from a theme
     * @param $asset
     * @return string
     */
    public function asset($asset);

}