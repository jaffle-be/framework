<?php

use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Price;
use Modules\Shop\Product\Product;
use Modules\Shop\Product\Promotion;
use Modules\System\Seeder;

class ShopTableSeeder extends Seeder
{

    public function run()
    {
        for($i = 0; $i < 5; $i++)
        {
            Brand::create([
                'name' => $this->faker->word
            ]);
        }

        $brands = Brand::lists('id')->toArray();

        for($i = 0; $i < 25; $i++)
        {
            $product = new Product([
                'name' => $this->faker->word,
                'eancode' => $this->faker->ean13,
                'upc' => $this->faker->ean8,
                'text' => $this->faker->paragraphs(3, true)
            ]);

            shuffle($brands);

            $product->brand_id = $brands[0];

            $product->save();

            $product->price()->save(new Price(['value']));

            $product->promotion()->save(new Promotion(['value']));
        }
    }

}