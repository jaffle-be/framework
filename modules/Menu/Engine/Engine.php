<?php

namespace Modules\Menu\Engine;

use Illuminate\Contracts\View\Factory;

/**
 * Class Engine
 * @package Modules\Menu\Engine
 */
class Engine
{
    protected $view;

    /**
     * @param Factory $view
     */
    public function __construct(Factory $view)
    {
        $this->view = $view;
    }

    /**
     * @param $theme
     * @param $items
     * @return \Illuminate\Contracts\View\View
     */
    public function render($theme, $items)
    {
        return $this->view->make($theme, [
            'items' => $items,
        ]);
    }
}
