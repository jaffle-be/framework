<?php namespace App\Menu\Http\Admin;

use App\Menu\Menu;
use App\Menu\MenuItem;
use App\System\Http\AdminController;
use Illuminate\Http\Request;

class MenuItemController extends AdminController
{

    public function store(Menu $menu, MenuItem $menuItem, Request $request)
    {
        $input = translation_input($request, ['name']);

        return $menuItem->create($input);
    }

    public function update(Menu $menu, MenuItem $menuItem, Request $request)
    {
        $menuItem->load('translations');

        $input = translation_input($request, ['name']);

        $menuItem->fill($input);

        $menuItem->save();

        return $menuItem;
    }

    public function destroy(Menu $menu, MenuItem $menuItem)
    {
        if($menuItem->delete())
        {
            $menuItem->id = 0;
        }

        return $menuItem;
    }

}