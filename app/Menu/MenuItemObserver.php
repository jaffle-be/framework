<?php namespace App\Menu;

class MenuItemObserver
{

    public function deleting(MenuItem $item)
    {
        return $item->translations()->delete();
    }

}