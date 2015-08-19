<?php

use App\Shop\Product\Brand;
use App\Shop\Product\Price;
use App\Shop\Product\Product;
use App\Shop\Product\Promotion;
use App\System\Seeder;

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