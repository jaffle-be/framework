<?php

namespace Modules\Menu;

interface MenuRepositoryInterface
{
    public function getMenus();

    public function findMenu($id);

    public function createMenu(array $payload);

    public function cleanMenu(Menu $menu);

    public function sortMenu($menu, $order);

    /**
     * @return MenuItem
     */
    public function createItem(array $payload);

    /**
     * @return MenuItem
     */
    public function updateItem(MenuItem $item, array $payload);
}
