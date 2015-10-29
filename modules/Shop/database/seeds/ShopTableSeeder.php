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

    protected $image_names = [
        'BLOG_IMG_9908.jpg',
        'BLOG_IMG_9985.jpg',
        'BLOG_O14A0247.jpg',
        'BLOG_O14A0256.jpg',
        'BLOG_O14A0436.jpg',
    ];

    protected $prefix;

    protected $images;

    public function __construct(\Intervention\Image\ImageManager $images)
    {
        $this->images = $images;

        $this->model = new Product();

        $this->prefix = __DIR__ . '/../images/';

        parent::__construct();
    }

    public function run()
    {
        $this->call('BrandTableSeeder');
        $this->call('CategoryTableSeeder');

        $this->productBases();
    }

    protected function productBases()
    {
        $brands = Brand::all();
        $categories = Category::all();

        foreach([1, 2] as $account)
        {
            for ($i = 0; $i < 10; $i++) {
                $name = $this->faker->userName;

                $ean = $this->faker->ean13;

                $product = new Product([
                    'ean' => $ean,
                    'upc' => substr($ean, 0, 12),
                    'nl'  => [
                        'name'    => $name,
                        'title'   => $name,
                        'content' => $this->nl->realText(1000),
                    ],
                    'en'  => [
                        'name'    => $name,
                        'title'   => $name,
                        'content' => $this->nl->realText(1000),
                    ],
                    'fr'  => [
                        'name'    => $name,
                        'title'   => $name,
                        'content' => $this->nl->realText(1000),
                    ],
                    'de'  => [
                        'name'    => $name,
                        'title'   => $name,
                        'content' => $this->nl->realText(1000),
                    ],
                ]);

                $product->brand()->associate($brands->random(1));
                $product->save();

                $this->newImage($product);

                if (rand(0, 1)) {
                    $this->newImage($product);
                }

                if (rand(0, 1)) {
                    $product->categories()->sync([$categories->random(1)->id]);
                } else {
                    $product->categories()->sync($categories->random(2)->lists('id')->toArray());
                }

                $this->prices($product, $account);
                $this->promotions($product, $account);
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