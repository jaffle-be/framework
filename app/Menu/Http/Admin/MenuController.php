<?php namespace App\Menu\Http\Admin;

use App\Menu\Menu;
use App\Menu\MenuManager;
use App\Pages\PageRepository;
use App\System\Http\AdminController;
use App\Theme\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MenuController extends AdminController
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

    public function index(PageRepository $pages)
    {
        $menus = $this->menu->getMenus();

        foreach ($menus as $menu) {
            $usedPages = new Collection();

            foreach ($menu->items as $item) {
                if ($item->page) {
                    $usedPages->push($item->page);
                }
            }

            $menu->availablePages = $pages->with('translations')->but($usedPages)->get();
        }

        return $menus;
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