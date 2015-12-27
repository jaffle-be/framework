<?php

namespace Modules\Shop\Console;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\Account;
use Modules\Media\Commands\StoreNewImage;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\BrandTranslation;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\CategoryTranslation;
use Modules\Shop\Product\Product;
use Modules\Shop\Product\Property;
use Modules\Shop\Product\PropertyGroup;
use Modules\Shop\Product\PropertyOption;
use Modules\Shop\Product\PropertyOptionTranslation;
use Modules\Shop\Product\PropertyTranslation;
use Modules\Shop\Product\PropertyValue;

class ImportResults extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:philips';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import philips result';

    use DispatchesJobs;

    public function fire()
    {
        $results = json_decode(file_get_contents(base_path('results.json')));

        $brand = $this->brand();

        $account = $this->account();

        foreach ($results->hoofdcategories as $main_category) {
            foreach ($main_category->subcategories as $key => $sub) {
                if (isset($sub->producten)) {
                    $category = $this->category($sub);

                    $group = $this->propertyGroup($category);

                    foreach ($sub->producten as $data) {
                        if (isset($data->name, $data->product_title, $data->description)) {
                            $product = $this->productBase($account, $brand, $data, $category);
                            $this->productProperties($product, $data, $category, $group);
                            $this->productImages($account, $product, $data);
                        }
                    }
                }
            }
        }
    }

    protected function productProperties($product, $data, $category, $group)
    {
        foreach ($data->specs as $spec) {
            if (!empty($spec->spec) && !empty($spec->value)) {
                $prop = PropertyTranslation::where('name', $spec->spec)->first();

                if (!$prop) {
                    $prop = Property::create([
                        'type' => 'options',
                        'category_id' => $category->id,
                        'group_id' => $group->id,
                        'nl' => [
                            'name' => $spec->spec,
                        ],
                        'en' => [
                            'name' => $spec->spec,
                        ],
                    ]);
                    $prop = $prop->id;
                } else {
                    $prop = $prop->property_id;
                }

                $option = PropertyOptionTranslation::join('product_properties_options', 'product_properties_options.id', '=', 'product_properties_options_translations.option_id')
                    ->where('property_id', $prop)
                    ->where('name', $spec->value)->first();

                if (!$option) {
                    $option = PropertyOption::create([
                        'property_id' => $prop,
                        'nl' => [
                            'name' => $spec->value,
                        ],
                        'en' => [
                            'name' => $spec->value,
                        ],
                    ]);

                    $option = $option->id;
                } else {
                    $option = $option->option_id;
                }

                $value = PropertyValue::create([
                    'product_id' => $product->id,
                    'property_id' => $prop,
                    'option_id' => $option,
                ]);
            }
        }
    }

    protected function productImages($account, $product, $data)
    {
        $counter = 1;

        if (isset($data->image) && !empty($data->image)) {
            $this->addImage($account, $product, $data->image, $counter);
            ++$counter;
        }

        if (isset($data->images) && is_array($data->images)) {
            foreach ($data->images as $image) {
                if ($image) {
                    $this->addImage($account, $product, $image->image, $counter);
                    ++$counter;
                }
            }
        }
    }

    /**
     * @return mixed
     */
    protected function brand()
    {
        $brand = BrandTranslation::where('name', 'Philips')->first();

        if (!$brand) {
            $brand = Brand::create([
                'nl' => [
                    'name' => 'Philips',
                ],
                'en' => [
                    'name' => 'Philips',
                ],
            ]);

            $brand = $brand->id;

            return $brand;
        } else {
            $brand = $brand->brand_id;

            return $brand;
        }
    }

    /**
     * @return mixed
     */
    protected function account()
    {
        $account = Account::where('alias', env('APP_ALIAS'))->first();

        return $account;
    }

    /**
     * @return static
     */
    protected function category($sub)
    {
        $title = $sub->subcategorie;

        $category = CategoryTranslation::where('name', $title)->first();

        if (!$category) {
            $category = Category::create([
                'nl' => [
                    'name' => $title,
                ],
                'en' => [
                    'name' => $title,
                ],
            ]);

            return $category;
        } else {
            $category = $category->category;

            return $category;
        }
    }

    /**
     * @return mixed
     */
    protected function propertyGroup(Category $category)
    {
        $group = $category->propertyGroups()->save(new PropertyGroup([
            'nl' => [
                'name' => 'andere',
            ],
            'en' => [
                'name' => 'other',
            ],
        ]));

        return $group;
    }

    /**
     * @return static
     */
    protected function productBase($account, $brand, $data, $category)
    {
        $product = Product::create([
            'account_id' => $account->id,
            'brand_id' => $brand,
            'nl' => [
                'name' => $data->name,
                'title' => $data->product_title,
                'content' => $data->description,
            ],
            'en' => [
                'name' => $data->name,
            ],
        ]);

        $product->categories()->save($category);

        return $product;
    }

    /**
     * @internal param $data
     */
    protected function addImage($account, $product, $url, $counter)
    {
        $path = base_path('storage') . '/image_' . str_replace('/', '_', $product->name) . $counter . '.jpg';

        if (!app('files')->exists($path)) {
            $content = file_get_contents($url);

            //for some reason, storage_path is wrong in console?
            app('files')->put($path, $content);
        }

        $image = getimagesize($path);

        if ($image[0] > 270) {
            $this->dispatch(new StoreNewImage($account, $product, $path));
        }
    }
}
