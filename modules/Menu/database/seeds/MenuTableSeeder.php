<?php

use Modules\Menu\Menu;
use Modules\Menu\MenuItem;
use Modules\System\Seeder;

class MenuTableSeeder extends Seeder{

    public function run()
    {
        foreach(MenuItem::all() as $item)
        {
            $item->delete();
        }

        foreach(Menu::all() as $menu)
        {
            $menu->delete();
        }

        foreach([1, 2] as $account)
        {
            $menu = Menu::create([
                'name' => 'primary menu',
                'account_id' => $account,
            ]);

            Menu::create([
                'name' => 'footer menu',
                'account_id' => $account,
            ]);

            MenuItem::create([
                'menu_id' => $menu->id,
                'url' => 'http://google.be',
                'target_blank' => true,
                'nl' => ['name' => 'test'],
                'fr' => ['name' => 'test'],
                'de' => ['name' => 'test'],
                'en' => ['name' => 'test'],
            ]);

            $shop = MenuItem::create([
                'menu_id' => $menu->id,
                'url' => '/shop',
                'target_blank' => false,
                'nl' => ['name' => 'shop'],
                'fr' => ['name' => 'shop'],
                'de' => ['name' => 'shop'],
                'en' => ['name' => 'shop'],
            ]);

            MenuItem::create([
                'menu_id' => $menu->id,
                'url' => '/blog',
                'target_blank' => false,
                'nl' => ['name' => 'nieuws'],
                'fr' => ['name' => 'nieuws'],
                'de' => ['name' => 'nieuws'],
                'en' => ['name' => 'news'],

            ]);

            MenuItem::create([
                'menu_id' => $menu->id,
                'url' => '/portfolio',
                'target_blank' => false,
                'nl' => ['name' => 'onze werken'],
                'fr' => ['name' => 'onze werken'],
                'de' => ['name' => 'onze werken'],
                'en' => ['name' => 'projects'],

            ]);

            MenuItem::create([
                'menu_id' => $menu->id,
                'url' => '/team',
                'target_blank' => false,
                'nl' => ['name' => 'onze kraks'],
                'fr' => ['name' => 'onze kraks'],
                'de' => ['name' => 'onze kraks'],
                'en' => ['name' => 'about'],

            ]);

            MenuItem::create([
                'menu_id' => $menu->id,
                'url' => '/contact',
                'target_blank' => false,
                'nl' => ['name' => 'contact'],
                'fr' => ['name' => 'contact'],
                'de' => ['name' => 'contact'],
                'en' => ['name' => 'contact'],

            ]);

            MenuItem::create([
                'menu_id' => $menu->id,
                'parent_id' => $shop->id,
                'url' => '/shop/tv-vision',
                'target_blank' => false,
                'nl' => ['name' => 'TV / vision'],
                'fr' => ['name' => 'TV / vision'],
                'de' => ['name' => 'TV / vision'],
                'en' => ['name' => 'TV / vision'],

            ]);

            MenuItem::create([
                'menu_id' => $menu->id,
                'parent_id' => $shop->id,
                'url' => '/shop/telefonie-mobile',
                'target_blank' => false,
                'nl' => ['name' => 'telefonie / mobile'],
                'fr' => ['name' => 'telefonie / mobile'],
                'de' => ['name' => 'telefonie / mobile'],
                'en' => ['name' => 'phone / mobile'],

            ]);

            MenuItem::create([
                'menu_id' => $menu->id,
                'parent_id' => $shop->id,
                'url' => '/shop/computer-tablets',
                'target_blank' => false,
                'nl' => ['name' => 'computer / tablets'],
                'fr' => ['name' => 'computer / tablets'],
                'de' => ['name' => 'computer / tablets'],
                'en' => ['name' => 'computer / tablets'],

            ]);

            MenuItem::create([
                'menu_id' => $menu->id,
                'parent_id' => $shop->id,
                'url' => '/shop/office-gps',
                'target_blank' => false,
                'nl' => ['name' => 'office / gps'],
                'fr' => ['name' => 'office / gps'],
                'de' => ['name' => 'office / gps'],
                'en' => ['name' => 'office / gps'],

            ]);

            MenuItem::create([
                'menu_id' => $menu->id,
                'parent_id' => $shop->id,
                'url' => '/shop/huishoud',
                'target_blank' => false,
                'nl' => ['name' => 'huishoud'],
                'fr' => ['name' => 'huishoud'],
                'de' => ['name' => 'huishoud'],
                'en' => ['name' => 'household'],

            ]);
        }

    }
}