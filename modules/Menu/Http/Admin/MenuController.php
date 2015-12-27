<?php

namespace Modules\Menu\Http\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Account\AccountManager;
use Modules\Menu\Menu;
use Modules\Menu\MenuManager;
use Modules\Module\ModuleRoute;
use Modules\Pages\PageRepository;
use Modules\System\Http\AdminController;
use Modules\Theme\ThemeManager;

/**
 * Class MenuController
 * @package Modules\Menu\Http\Admin
 */
class MenuController extends AdminController
{
    /**
     * @var MenuManager
     */
    protected $menu;

    /**
     * @param ThemeManager $theme
     * @param MenuManager $menu
     */
    public function __construct(ThemeManager $theme, MenuManager $menu)
    {
        $this->menu = $menu;

        parent::__construct($theme);
    }

    /**
     * @param PageRepository $pages
     * @param ModuleRoute $route
     * @param AccountManager $manager
     * @return mixed
     */
    public function index(PageRepository $pages, ModuleRoute $route, AccountManager $manager)
    {
        $menus = $this->menu->getMenus();

        $validRoutes = $manager->account()->modules->routes();

        $validRoutes = $validRoutes->lists('id')->toArray();

        foreach ($menus as $menu) {
            $usedPages = new Collection();
            $usedRoutes = new Collection();

            foreach ($menu->items as $item) {
                if ($item->page) {
                    $usedPages->push($item->page);
                }

                if ($item->route) {
                    $usedRoutes->push($item->route);
                }
            }

            $menu->availablePages = $pages->with('translations')->mainPages()->but($usedPages)->get();

            $menu->availableRoutes = $route->with('translations')->whereIn('id', $validRoutes)->but($usedRoutes)->get();
        }

        return $menus;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        return $this->menu->createMenu([
            'name' => $request->get('name'),
        ]);
    }

    /**
     * @param Menu $menu
     * @return mixed
     */
    public function destroy(Menu $menu)
    {
        $this->menu->cleanMenu($menu);

        return $this->menu->findMenu($menu->id);
    }

    /**
     * @param Menu $menu
     * @param Request $request
     */
    public function sort(Menu $menu, Request $request)
    {
        $order = $request->get('order');

        $this->menu->sortMenu($menu, $order);
    }
}
