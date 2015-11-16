<?php

use Modules\Account\Account;
use Modules\Shop\Product\ActivePrice;
use Modules\Shop\Product\ActivePromotion;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Price;
use Modules\Shop\Product\Product;
use Modules\Shop\Product\Promotion;
use Modules\System\Seeder;

class ShopTableSeeder extends Seeder
{

    public function __construct()
    {
        $this->model = new Product();

        parent::__construct();
    }

    public function run($count = 15)
    {
        if (Brand::count() == 0) {
            $this->call('BrandTableSeeder');
        }
        if (Category::count() == 0) {
            $this->call('CategoryTableSeeder');
        }

        $this->productBases($count);
    }

    protected function productBases($amount)
    {
        $brands = Brand::all();
        $categories = Category::all();

        $accounts = Account::take(2)->get();

        foreach($accounts as $account)
        {
            for ($i = 0; $i < $amount; $i++) {

                $product = factory(Product::class)->create([
                    'brand_id' => $brands->random(1)->id,
                    'account_id' => $account->id,
                ]);

                $this->addImages($product);

                if (rand(0, 1)) {
                    $product->categories()->sync([$categories->random(1)->id]);
                } else {
                    $product->categories()->sync($categories->random(2)->lists('id')->toArray());
                }

                $this->prices($product, $account->id);
                $this->promotions($product, $account->id);
            }
        }

    }

    protected function prices(Product $product, $account)
    {
        $count = rand(1, 2);

        $counter = 0;

        while ($counter < $count) {

            $product->priceHistory()->save(new Price([
                'account_id'  => $account,
                'active_from' => $this->faker->dateTimeBetween('-3 years', '-5 months'),
                'active_to'   => $this->faker->dateTimeBetween('-5 months', '-2 days'),
                'value'       => rand(1000, 200000) / 10,
            ]));

            $counter++;
        }

        if (rand(0, 1)) {
            $product->price()->save(new ActivePrice([
                'account_id'   => $account,
                'activated_on' => $this->faker->dateTimeBetween('-6 months', '-2 days'),
                'value'        => rand(1000, 200000) / 10
            ]));
        }
    }

    protected function promotions(Product $product, $account)
    {
        $count = rand(1, 2);

        $counter = 0;

        while ($counter < $count) {
            $absolute = rand(0, 1);
            $dates = rand(0, 1);

            $product->promotionHistory()->save(new Promotion([
                'account_id'  => $account,
                'absolute'    => $absolute,
                'active_from' => $this->faker->dateTimeBetween('-3 years', '-5 months'),
                'active_to'   => $this->faker->dateTimeBetween('-5 months', '-2 days'),
                'value'       => $absolute ? rand(1, 5) * 10 : rand(1, 5 * 10 / 2),
                'from'        => $dates ? $this->faker->dateTimeBetween('-3 years', '-5 months') : null,
                'to'          => $dates ? $this->faker->dateTimeBetween('-5 months', '-2 days') : null,
            ]));

            $counter++;
        }

        if (rand(0, 1)) {
            $absolute = rand(0, 1);
            $dates = rand(0, 1);

            $product->promotion()->save(new ActivePromotion([
                'account_id'   => $account,
                'absolute'     => $absolute,
                'activated_on' => $this->faker->dateTimeBetween('-6 months', '-2 days'),
                'value'        => $absolute ? rand(1, 5) * 10 : rand(1, 5 * 10 / 2),
                'from'         => $dates ? $this->faker->dateTimeBetween('-3 years', '-5 months') : null,
                'to'           => $dates ? $this->faker->dateTimeBetween('-5 months', '-2 days') : null,
            ]));
        }
    }

}