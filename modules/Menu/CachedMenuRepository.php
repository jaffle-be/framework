<?php

namespace Modules\Menu;

use Illuminate\Contracts\Cache\Repository;
use Modules\Account\AccountManager;

/**
 * Class CachedMenuRepository
 * @package Modules\Menu
 */
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

    /**
     * @param MenuRepository $menu
     * @param Repository $cache
     * @param AccountManager $manager
     */
    public function __construct(MenuRepository $menu, Repository $cache, AccountManager $manager)
    {
        $this->menu = $menu;
        $this->cache = $cache;
        $this->account = $manager->account();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findMenu($id)
    {
        return $this->menu->findMenu($id);
    }

    /**
     * @return mixed
     */
    public function getMenus()
    {
        return $this->cache->sear('menus', function () {
            return $this->menu->getMenus();
        });
    }

    /**
     * @param array $payload
     * @return mixed
     */
    public function createMenu(array $payload)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        /*
         * simple strategy: for any database altering method we do the following:
         * - call the parent method
         * - bust the cache
         */

        $result = call_user_func_array([$this->menu, $name], $arguments);

        $this->cache->forget('menus');

        return $result;
    }

    /**
     * @param Menu $menu
     * @return mixed
     */
    public function cleanMenu(Menu $menu)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    /**
     * @param $menu
     * @param $order
     * @return mixed
     */
    public function sortMenu($menu, $order)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $payload
     * @return mixed
     */
    public function createItem(array $payload)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    /**
     * @param MenuItem $item
     * @param array $payload
     * @return mixed
     */
    public function updateItem(MenuItem $item, array $payload)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }
}
