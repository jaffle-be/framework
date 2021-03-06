<?php

use Illuminate\Support\Collection;
use Modules\Account\Account;
use Modules\Shop\Product\ActivePrice;
use Modules\Shop\Product\ActivePromotion;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Price;
use Modules\Shop\Product\Product;
use Modules\Shop\Product\Promotion;
use Modules\Shop\Product\Property;
use Modules\Shop\Product\PropertyGroup;
use Modules\Shop\Product\PropertyOption;
use Modules\Shop\Product\PropertyUnit;
use Modules\Shop\Product\PropertyValue;
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
        $this->call(BrandTableSeeder::class);
        $this->call(CategoryTableSeeder::class);

        if (Property::count() == 0) {
            $this->baseProperties();
        }

        $this->productBases($count);
    }

    protected function productBases($amount)
    {
        $brands = Brand::all();
        $categories = Category::whereNull('original_id')->get();
        $categories->load('synonyms');

        $accounts = Account::take(2)->get();

        foreach ($accounts as $account) {
            for ($i = 0; $i < $amount; $i++) {
                $product = factory(Product::class)->create([
                    'brand_id'   => $brands->random(1)->id,
                    'account_id' => $account->id,
                ]);

                $this->addImages($product);

                $category = $categories->random(1);

                $categoryIds = [$category->id];

                if ($category->synonyms) {
                    $categoryIds = array_merge($categoryIds, $category->synonyms->lists('id')->toArray());
                }

                $product->categories()->sync($categoryIds);

                $this->properties($product, $category);

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
                'value'        => rand(1000, 200000) / 10,
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

    protected function properties(Product $product, Category $category)
    {
        $properties = Property::where('category_id', $category->id)->get();

        $properties = $properties->random(rand(5, 10));

        $values = new Collection();

        foreach ($properties as $property) {
            $payload = [
                'property_id' => $property->id,
            ];

            if ($property->options->count()) {
                $payload['option_id'] = $property->options->random(1)->id;
            }

            $values->push(factory(PropertyValue::class)->make($payload));
        }

        $product->properties()->saveMany($values);
    }

    protected function baseProperties()
    {
        factory(PropertyUnit::class)->times(35)->create();
        $units = PropertyUnit::all();

        foreach (Category::all() as $category) {
            $groups = factory(PropertyGroup::class)->times(4)->create([
                'category_id' => $category->id,
            ]);

            factory(Property::class, 'numeric')->times(4)->create([
                'unit_id'     => $units->random(1)->id,
                'group_id'    => $groups->random(1)->id,
                'category_id' => $category->id,
            ]);
            factory(Property::class, 'boolean')->times(5)->create([
                'group_id'    => $groups->random(1)->id,
                'category_id' => $category->id,
            ]);
            factory(Property::class, 'float')->times(1)->create([
                'group_id'    => $groups->random(1)->id,
                'category_id' => $category->id,
            ]);
            factory(Property::class, 'string')->times(3)->create([
                'group_id'    => $groups->random(1)->id,
                'category_id' => $category->id,
            ]);

            factory(Property::class, 'options')->times(3)->create([
                'group_id'    => $groups->random(1)->id,
                'category_id' => $category->id,
            ])->each(function ($property) {
                factory(PropertyOption::class)->times(rand(4, 10))->create([
                    'property_id' => $property->id,
                ]);
            });
        }
    }
}
