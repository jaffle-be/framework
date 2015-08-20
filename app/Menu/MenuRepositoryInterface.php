<?php namespace App\Menu;

interface MenuRepositoryInterface {

    public function getSupportedMenus(array $supports);
}