<?php namespace App\Menu\Http\Admin;

use App\Menu\Menu;
use App\Menu\MenuItem;
use App\Menu\MenuManager;
use App\System\Http\AdminController;
use App\Theme\ThemeManager;
use Illuminate\Http\Request;

class MenuItemController extends AdminController
{

    /**
     * @var MenuManager
     */
    protected $menu;

    /**
     * @param ThemeManager $theme
     * @param MenuManager  $menu
     */
    public function __construct(ThemeManager $theme, MenuManager $menu)
    {
        $this->menu = $menu;

        parent::__construct($theme);
    }

    /**
     * @param Menu     $menu
     * @param MenuItem $item
     * @param Request  $request
     *
     * @return mixed
     */
    public function store(Menu $menu, MenuItem $item, Request $request)
    {
        $input = translation_input($request, ['name']);

        return $this->menu->createItem($input);
    }

    /**
     * @param Menu     $menu
     * @param MenuItem $item
     * @param Request  $request
     *
     * @return mixed
     */
    public function update(Menu $menu, MenuItem $item, Request $request)
    {
        $input = translation_input($request, ['name']);

        return $this->menu->updateItem($item, $input);
    }

    /**
     * @param Menu     $menu
     * @param MenuItem $item
     *
     * @return mixed
     */
    public function destroy(Menu $menu, MenuItem $item)
    {
        return $this->menu->deleteItem($item);
    }

}