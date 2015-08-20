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

    public function getSupportedMenus(array $supports)
    {
        $query = $this->menu->with($this->relations());

        $this->menu->scopeSupported($query, $supports);

        return $query->get();
    }

    /**
     * @return array
     */
    protected function relations()
    {
        return ['items', 'items.children', 'items.translations', 'items.children.translations'];
    }
}