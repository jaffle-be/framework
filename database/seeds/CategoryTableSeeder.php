<?php

use Modules\Shop\Product\Category;
use Modules\System\Seeder;

class CategoryTableSeeder extends Seeder
{

    public function run()
    {
        $names = [
            'Droogkast', 'Wasmachine', 'Koelkast', 'Diepvriezer', 'Microgolfoven', 'Gsm', 'Tv', 'Gps', 'Haardroger', 'Haartrimmer',
        ];

        for ($i = 0; $i < 10; $i++) {
            Category::create([
                'nl' => ['name' => $names[$i]],
                'en' => ['name' => $names[$i]],
                'fr' => ['name' => $names[$i]],
                'de' => ['name' => $names[$i]],
            ]);
        }
    }

}