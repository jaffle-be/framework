<?php

use Modules\Menu\Menu;
use Modules\Menu\MenuItem;
use Modules\Module\ModuleRoute;
use Modules\System\Seeder;

class MenuTableSeeder extends Seeder{

    public function run()
    {
        foreach(MenuItem::all() as $item)
        {
            $item->delete();
        }

        foreach(Menu::all() as $menu)
        {
            $menu->delete();
        }

        foreach([1, 2] as $account)
        {
            $menu = Menu::create([
                'name' => 'primary menu',
                'account_id' => $account,
            ]);

            Menu::create([
                'name' => 'footer menu',
                'account_id' => $account,
            ]);

            $routes = ModuleRoute::all();

            foreach($routes as $route)
            {
                MenuItem::create([
                    'menu_id' => $menu->id,
                    'module_route_id' => $route->id,
                    'nl' => ['name' => $this->cleanName($route->name)],
                    'fr' => ['name' => $this->cleanName($route->name)],
                    'de' => ['name' => $this->cleanName($route->name)],
                    'en' => ['name' => $this->cleanName($route->name)],
                ]);
            }
        }

    }

    protected function cleanName($name)
    {
        return str_replace(['store.', '.index'], '', $name);
    }
}