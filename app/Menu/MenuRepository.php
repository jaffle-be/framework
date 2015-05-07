<?php namespace App\Menu;

class MenuRepository implements MenuRepositoryInterface{

    /**
     * @var Menu
     */
    protected $menu;

    /**
     * @var MenuItem
     */
    protected $item;

    public function __construct(Menu $menu, MenuItem $item)
    {
        $this->menu = $menu;
        $this->item = $item;
    }

    public function getAllMenus()
    {
        $query = $this->menu->with(['items']);

        return $query->get();
    }

    public function getSupportedMenus(array $supports)
    {
        $query = $this->menu->with(['items']);

        $this->menu->scopeSupported($query, $supports);

        return $query->get();
    }
}