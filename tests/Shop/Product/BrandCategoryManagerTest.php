<?php

namespace Test\Shop\Product;

use Mockery;
use Modules\Account\Account;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\BrandCategoryManager;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;
use Test\AdminTestCase;

class BrandCategoryManagerTest extends AdminTestCase
{
    public function testAttachingWillAddNewCombinationIfNoneExists()
    {
        $manager = app('Modules\Shop\Product\BrandCategoryManager');

        $product = factory(Product::class)->create([
            'brand_id' => factory(Brand::class)->create()->id,
            'account_id' => factory(Account::class)->create()->id,
        ]);

        $category = factory(Category::class)->create();

        $manager->attach(['product_id' => $product->id, 'category_id' => $category->id]);

        $this->seeInDatabase('product_brands_pivot', ['brand_id' => $product->brand_id, 'category_id' => $category->id]);
    }

    public function testAttachingWillFireEvent()
    {
        $product = factory(Product::class)->create([
            'brand_id' => factory(Brand::class)->create()->id,
            'account_id' => factory(Account::class)->create()->id,
        ]);

        $category = factory(Category::class)->create();

        $db = app('Illuminate\Database\DatabaseManager');

        $mock = Mockery::spy('Illuminate\Contracts\Events\Dispatcher');
        $mock->shouldReceive('fire')->with('eloquent.attached: brand_categories', [
            'brand_id' => $product->brand_id,
            'category_id' => $category->id,
        ]);

        $manager = new BrandCategoryManager($db, $mock, new Product, new Brand, new Category);

        $manager->attach(['product_id' => $product->id, 'category_id' => $category->id]);
    }

    public function testAttachingWillKeepCombinationIfItAlreadyExisted()
    {
        $brand_id = factory(Brand::class)->create()->id;

        $product1 = factory(Product::class)->create([
            'brand_id' => $brand_id,
            'account_id' => factory(Account::class)->create()->id,
        ]);

        $product2 = factory(Product::class)->create([
            'brand_id' => $brand_id,
            'account_id' => factory(Account::class)->create()->id,
        ]);

        $category = factory(Category::class)->create();

        $product1->categories()->attach($category);

        $manager = app('Modules\Shop\Product\BrandCategoryManager');
        $manager->attach([
            'product_id' => $product2->id,
            'category_id' => $category->id,
        ]);

        $this->seeInDatabase('product_brands_pivot', ['brand_id' => $brand_id, 'category_id' => $category->id]);
    }

    public function testDetachingWillNotRemoveCombinationIfItStillExists()
    {
        $brand_id = factory(Brand::class)->create()->id;

        $product1 = factory(Product::class)->create([
            'brand_id' => $brand_id,
            'account_id' => factory(Account::class)->create()->id,
        ]);

        $product2 = factory(Product::class)->create([
            'brand_id' => $brand_id,
            'account_id' => factory(Account::class)->create()->id,
        ]);

        $category = factory(Category::class)->create();

        $product1->categories()->attach($category);
        $product2->categories()->attach($category);

        $manager = app('Modules\Shop\Product\BrandCategoryManager');
        $manager->detach([
            'product_id' => $product2->id,
            'category_id' => $category->id,
        ]);

        $this->seeInDatabase('product_brands_pivot', ['brand_id' => $brand_id, 'category_id' => $category->id]);
    }

    public function testDetachingWillRemoveCombinationIfItNoLongerExists()
    {
        $brand_id = factory(Brand::class)->create()->id;

        $product1 = factory(Product::class)->create([
            'brand_id' => $brand_id,
            'account_id' => factory(Account::class)->create()->id,
        ]);

        $category = factory(Category::class)->create();

        $product1->categories()->attach($category);

        //need to manually detach the actual link in the product_categories_pivot
        //so we can test the part this manager is responsible for
        \DB::table('product_categories_pivot')->where('product_id', $product1->id)
            ->where('category_id', $category->id)
            ->delete();

        $manager = app('Modules\Shop\Product\BrandCategoryManager');
        $manager->detach([
            'product_id' => $product1->id,
            'category_id' => $category->id,
        ]);

        $this->notSeeInDatabase('product_brands_pivot', ['brand_id' => $brand_id, 'category_id' => $category->id]);
    }

    public function testDetachingWillFireDetachedEventIfItActuallyDetached()
    {
        $brand_id = factory(Brand::class)->create()->id;

        $product1 = factory(Product::class)->create([
            'brand_id' => $brand_id,
            'account_id' => factory(Account::class)->create()->id,
        ]);

        $category = factory(Category::class)->create();

        $product1->categories()->attach($category);

        //need to manually detach the actual link in the product_categories_pivot
        //so we can test the part this manager is responsible for
        \DB::table('product_categories_pivot')->where('product_id', $product1->id)
            ->where('category_id', $category->id)
            ->delete();

        $db = app('Illuminate\Database\DatabaseManager');

        $mock = Mockery::spy('Illuminate\Contracts\Events\Dispatcher');
        $mock->shouldReceive('fire')->with('eloquent.detached: brand_categories', [
            'brand_id' => $product1->brand_id,
            'category_id' => $category->id,
        ]);

        $manager = new BrandCategoryManager($db, $mock, new Product, new Brand, new Category);
        $manager->detach([
            'product_id' => $product1->id,
            'category_id' => $category->id,
        ]);
    }
}
