<?php

namespace Modules\Module;

use Illuminate\Database\Eloquent\Collection;

class ModuleCollection extends Collection
{
    public function active($module)
    {
        return $this->first(function ($key, $item) use ($module) {
            return $item->namespace == $module;
        }) ? true : false;
    }

    public function routes()
    {
        $routes = new Collection();

        foreach ($this->items as $module) {
            foreach ($module->routes as $route) {
                $routes->push($route);
            }
        }

        return $routes;
    }
}
