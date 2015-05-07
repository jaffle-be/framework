<?php namespace App\Menu;

interface MenuRepositoryInterface {

    public function getAllMenus();

    public function getSupportedMenus(array $supports);
}