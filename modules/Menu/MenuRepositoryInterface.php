<?php

namespace Modules\Menu;

/**
 * Interface MenuRepositoryInterface
 * @package Modules\Menu
 */
interface MenuRepositoryInterface
{
    public function getMenus();

    /**
     * @param $id
     * @return mixed
     */
    public function findMenu($id);

    /**
     * @param array $payload
     * @return mixed
     */
    public function createMenu(array $payload);

    /**
     * @param Menu $menu
     * @return mixed
     */
    public function cleanMenu(Menu $menu);

    /**
     * @param $menu
     * @param $order
     * @return mixed
     */
    public function sortMenu($menu, $order);

    /**
     * @param array $payload
     * @return
     */
    public function createItem(array $payload);

    /**
     * @param MenuItem $item
     * @param array $payload
     * @return
     */
    public function updateItem(MenuItem $item, array $payload);
}
