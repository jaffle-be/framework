<?php

use Modules\Shop\Product\Brand;
use Modules\System\Seeder;

class BrandTableSeeder extends Seeder
{

    public function run()
    {
        $names = ['Philips', 'Samsung', 'Liebherr', 'Sony', 'Panasonic', 'Loewe', 'LG', 'Apple', 'HTC', 'AEG'];

        for ($i = 0; $i < 10; $i++) {
            Brand::create([
                'nl' => ['name' => $names[$i], 'description' => $this->nl->realText(1000)],
                'fr' => ['name' => $names[$i], 'description' => $this->fr->realText(1000)],
                'en' => ['name' => $names[$i], 'description' => $this->en->realText(1000)],
                'de' => ['name' => $names[$i], 'description' => $this->de->realText(1000)],
            ]);
        }
    }

}