<?php namespace Modules\Menu;

use Illuminate\Contracts\Cache\Repository;
use Modules\Account\AccountManager;

class CachedMenuRepository implements MenuRepositoryInterface
{

    /**
     * @var MenuRepository
     */
    protected $menu;

    /**
     * @var Repository
     */
    protected $cache;

    public function __construct(MenuRepository $menu, Repository $cache, AccountManager $manager)
    {
        $this->menu = $menu;
        $this->cache = $cache;
        $this->account = $manager->account();
    }

    public function findMenu($id)
    {
        return $this->menu->findMenu($id);
    }

    public function getMenus()
    {
        return $this->cache->sear('menus', function () {
            return $this->menu->getMenus();
        });
    }

    function __call($name, $arguments)
    {
        /**
         * simple strategy: for any database altering method we do the following:
         * - call the parent method
         * - bust the cache
         */

        $result = call_user_func_array([$this->menu, $name], $arguments);

        $this->cache->forget('menus');

        return $result;
    }

    public function createMenu(array $payload)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    public function cleanMenu(Menu $menu)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    public function sortMenu($menu, $order)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    public function createItem(array $payload)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    public function updateItem(MenuItem $item, array $payload)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

}