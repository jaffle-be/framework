<?php namespace App\Module;

use Illuminate\Database\Eloquent\Collection;

class ModuleCollection extends Collection
{

    public function routes()
    {
        $routes = new Collection();

        foreach($this->items as $module)
        {
            foreach($module->routes as $route)
            {
                $routes->push($route);
            }
        }

        return $routes;
    }

}