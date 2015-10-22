<?php namespace App\Menu\Http\Admin;

use App\Account\AccountManager;
use App\Menu\Menu;
use App\Menu\MenuItem;
use App\Menu\MenuManager;
use App\Module\ModuleRoute;
use App\Pages\Page;
use App\System\Http\AdminController;
use App\System\Locale;
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
    public function __construct(ThemeManager $theme, MenuManager $menu, AccountManager $account)
    {
        $this->menu = $menu;

        $this->account = $account;

        parent::__construct($theme);
    }

    /**
     * @param Menu     $menu
     * @param MenuItem $item
     * @param Request  $request
     *
     * @return mixed
     */
    public function store(Menu $menu, MenuItem $item, Request $request, Page $page, Locale $locale, ModuleRoute $route)
    {
        $input = translation_input($request, ['name']);

        if (isset($input['page_id'])) {
            //make sure to set the default labels for the menu item
            $page = $page->findOrFail($input['page_id']);

            foreach ($locale->all() as $locale) {
                $translation = $page->translate($locale->slug);

                if ($translation) {
                    $input[$locale->slug]['name'] = $translation->title;
                }
            }
        } elseif (isset($input['module_route_id'])) {
            //make sure to set the default labels for the menu item
            $route = $route->findOrFail($input['module_route_id']);

            foreach ($locale->all() as $locale) {
                $translation = $route->translate($locale->slug);

                if ($translation) {
                    $input[$locale->slug]['name'] = $translation->title;
                }
            }

        } else {

            $rules = [
                'url' => 'required',
            ];

            foreach ($this->account->account()->locales as $locale) {
                $rules = array_merge($rules, [
                    "translations.{$locale->slug}.name" => 'required',
                ]);
            }

            $this->validate($request, $rules);
        }

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
        //make sure to load the relationships, so we can use them to make that type of resource available again.
        //example: when deleting a menuitem refering to a page,
        //we need to make the page available again in the UI.
        //if we load it, before deleting, the page object will be there in the response.
        $item->load(['page', 'page.translations', 'route', 'route.translations']);

        return $this->menu->deleteItem($item);
    }

}