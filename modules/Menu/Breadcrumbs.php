<?php

namespace Modules\Menu;

use DaveJamesMiller\Breadcrumbs\CurrentRoute;
use DaveJamesMiller\Breadcrumbs\Manager;
use Illuminate\View\Factory;

/**
 * Class Breadcrumbs
 * @package Modules\Menu
 */
class Breadcrumbs
{
    protected $manager;

    protected $route;

    protected $view;

    protected $viewName;

    /**
     * @param Manager $manager
     * @param CurrentRoute $route
     * @param Factory $view
     */
    public function __construct(Manager $manager, CurrentRoute $route, Factory $view)
    {
        $this->manager = $manager;
        $this->route = $route;
        $this->view = $view;
    }

    /**
     * @param $view
     */
    public function setView($view)
    {
        $this->viewName = $view;

        $this->manager->setView($view);
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render(array $params = [])
    {
        if (empty($params)) {
            return $this->manager->renderIfExists();
        } else {
            $crumbs = $this->manager->generateIfExists();

            return $this->view->make($this->viewName, array_merge(['breadcrumbs' => $crumbs], $params));
        }
    }

    /**
     * @param $method
     * @param $params
     */
    public function __call($method, $params)
    {
        call_user_func_array([$this->manager, $method], $params);
    }
}
