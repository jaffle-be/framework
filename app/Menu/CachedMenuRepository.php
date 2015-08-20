<?php namespace App\Menu;

use App\Account\AccountManager;
use Illuminate\Contracts\Cache\Repository;

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

    public function getSupportedMenus(array $supports)
    {
        if (!$this->cache->has('menus')) {
            $this->cache->sear('menus', function () use ($supports) {
                return $this->menu->getSupportedMenus($supports);
            });
        }

        return $this->cache->get('menus');
    }

}