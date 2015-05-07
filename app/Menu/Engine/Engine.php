<?php namespace App\Menu\Engine;

use Illuminate\Contracts\View\Factory;

class Engine {

    protected $view;

    public function __construct(Factory $view)
    {
        $this->view = $view;
    }

    public function render($theme, $items)
    {
        return $this->view->make($theme, [
            'items' => $items
        ]);

        return sprintf('rendering theme %s with %d items in the menu', $theme, count($items));
    }

}