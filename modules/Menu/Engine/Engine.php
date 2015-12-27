<?php

namespace Modules\Menu\Engine;

use Illuminate\Contracts\View\Factory;

class Engine
{

    protected $view;

    public function __construct(Factory $view)
    {
        $this->view = $view;
    }

    public function render($theme, $items)
    {
        return $this->view->make($theme, [
            'items' => $items,
        ]);
    }
}
