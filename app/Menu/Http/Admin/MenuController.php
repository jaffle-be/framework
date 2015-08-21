<?php namespace App\Menu\Http\Admin;

use App\Menu\Menu;
use App\Menu\MenuManager;
use App\System\Http\AdminController;
use App\Theme\ThemeManager;
use Illuminate\Http\Request;

class MenuController extends AdminController
{

    protected $menu;

    public function __construct(ThemeManager $theme, MenuManager $menu)
    {
        $this->menu = $menu;

        parent::__construct($theme);
    }

    public function index()
    {
        return $this->menu->getMenus();
    }

    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        return $this->menu->createMenu([
            'name' => $request->get('name')
        ]);
    }

    public function destroy(Menu $menu)
    {
        $this->menu->cleanMenu($menu);

        return $this->menu->findMenu($menu->id);
    }

    public function sort(Menu $menu, Request $request)
    {
        $order = $request->get('order');

        $this->menu->sortMenu($menu, $order);
    }

}