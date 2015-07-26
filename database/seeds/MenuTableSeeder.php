<?php

use App\Menu\MenuItem;
use Jaffle\Tools\Seeder;

class MenuTableSeeder extends Seeder{

    public function run()
    {
        MenuItem::create([
            'menu_id' => 1,
            'url' => '/shop',
            'name' => 'producten',
        ]);

        MenuItem::create([
            'menu_id' => 1,
            'url' => '/shop',
            'name' => 'promoties',
        ]);

        MenuItem::create([
            'menu_id' => 1,
            'url' => '/blog',
            'name' => 'nieuwsberichten',
        ]);

        MenuItem::create([
            'menu_id' => 1,
            'url' => '/portfolio',
            'name' => 'onze werken',
        ]);

        MenuItem::create([
            'menu_id' => 1,
            'url' => '/team',
            'name' => 'onze kraks',
        ]);

        MenuItem::create([
            'menu_id' => 1,
            'url' => '/contact',
            'name' => 'contact',
        ]);

        MenuItem::create([
            'menu_id' => 1,
            'parent_id' => 1,
            'url' => '/shop/tv-vision',
            'name' => 'TV / vision'
        ]);

        MenuItem::create([
            'menu_id' => 1,
            'parent_id' => 1,
            'url' => '/shop/telefonie-mobile',
            'name' => 'telefonie / mobile'
        ]);

        MenuItem::create([
            'menu_id' => 1,
            'parent_id' => 1,
            'url' => '/shop/computer-tablets',
            'name' => 'computer / tablets'
        ]);

        MenuItem::create([
            'menu_id' => 1,
            'parent_id' => 1,
            'url' => '/shop/office-gps',
            'name' => 'office / gps'
        ]);

        MenuItem::create([
            'menu_id' => 1,
            'parent_id' => 1,
            'url' => '/shop/huishoud',
            'name' => 'huishoud'
        ]);
    }

}