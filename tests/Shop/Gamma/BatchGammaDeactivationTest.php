<?php

namespace Test\Shop\Gamma;

use Illuminate\Database\Eloquent\Collection;
use Mockery as m;
use Modules\Account\Account;
use Modules\Shop\Gamma\ProductCategorySelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Jobs\Gamma\Notification\Handlers\BatchGammaDeactivation;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;
use Test\TestCase;

class BatchGammaDeactivationTest extends TestCase
{
    public function testItDoesntFireWhenNoActiveProducts()
    {
        $category = factory(Category::class)->create();
        $account = factory(Account::class)->create();
        $brand = factory(Brand::class)->create();

        $job = new BatchGammaDeactivation($category, $account, $brand);

        $gamma = m::mock(ProductSelection::class);
        $gamma->shouldReceive('countActiveProducts')->once()->andReturn(0);
        $gamma->shouldNotReceive('chunkActiveProducts');

        $job->handle($gamma);
    }

    public function testItDoesFireWhenActiveProducts()
    {
        $category = factory(Category::class)->create();
        $account = factory(Account::class)->create();
        $brand = factory(Brand::class)->create();

        $selections = new Collection();

        $gamma = m::mock(ProductSelection::class);
        $gamma->shouldReceive('countActiveProducts')->once()->andReturn(2);
        $gamma->shouldReceive('countActiveProducts')->once()->andReturn(0);
        //return empty collection, test for actual logic is done in other tests.
        $gamma->shouldReceive('chunkActiveProducts')->once()->andReturn($selections);

        $job = new BatchGammaDeactivation($category, $account, $brand);
        $job->handle($gamma);
    }

    public function testItSetsTheCategoryAsTrashedForTheSelections()
    {
        $category = factory(Category::class)->create();
        $account = factory(Account::class)->create();
        $brand = factory(Brand::class)->create();

        $selections = new Collection();

        $products = factory(Product::class)->times(2)->create([
            'account_id' => $account->id,
            'brand_id'   => $brand->id,
        ])->each(function ($product) use ($selections, $account, $category, $brand) {
            $product->categories()->attach($category);

            $selection = factory(ProductSelection::class)->create([
                'account_id' => $account->id,
                'brand_id'   => $brand->id,
                'product_id' => $product->id,
            ]);

            factory(ProductCategorySelection::class)->create([
                'selection_id' => $selection->id,
                'category_id'  => $category->id,
            ]);

            $selections->push($selection);
        });

        $job = new BatchGammaDeactivation($category, $account, $brand);
        $job->handle(app(ProductSelection::class));

        foreach ($selections as $selection) {
            $count = app('db')->table('product_gamma_categories')
                ->where([
                    'selection_id' => $selection->id,
                    'category_id'  => $category->id,
                ])
                //make sure it's trashed
                ->whereNotNull('deleted_at')
                ->count();

            $this->assertSame(1, $count);
        }
    }

    public function testItDoesNotTrashTheSelectionIfItStillHasActiveCategoriesForThatSelection()
    {
        $category = factory(Category::class)->create();
        $category2 = factory(Category::class)->create();
        $account = factory(Account::class)->create();
        $brand = factory(Brand::class)->create();

        $product = factory(Product::class)->create([
            'account_id' => $account->id,
            'brand_id'   => $brand->id,
        ]);
        $product->categories()->attach($category->id);
        $product->categories()->attach($category2->id);

        $selection = factory(ProductSelection::class)->create([
            'account_id' => $account->id,
            'brand_id'   => $brand->id,
            'product_id' => $product->id,
        ]);

        factory(ProductCategorySelection::class)->create([
            'selection_id' => $selection->id,
            'category_id'  => $category->id,
        ]);

        factory(ProductCategorySelection::class)->create([
            'selection_id' => $selection->id,
            'category_id'  => $category2->id,
        ]);

        $job = new BatchGammaDeactivation($category, $account, $brand);
        $job->handle(app(ProductSelection::class));

        $this->seeInDatabase('product_gamma', [
            'account_id'  => $account->id,
            'product_id' => $product->id,
            'deleted_at' => null,
        ]);
    }

    public function testItTrashesTheEntireSelectionIfNoMoreActiveCategories()
    {
        $category = factory(Category::class)->create();
        $category2 = factory(Category::class)->create();
        $account = factory(Account::class)->create();
        $brand = factory(Brand::class)->create();

        $product = factory(Product::class)->create([
            'account_id' => $account->id,
            'brand_id'   => $brand->id,
        ]);
        $product->categories()->attach($category->id);
        $product->categories()->attach($category2->id);

        $selection = factory(ProductSelection::class)->create([
            'account_id' => $account->id,
            'brand_id'   => $brand->id,
            'product_id' => $product->id,
        ]);

        factory(ProductCategorySelection::class)->create([
            'selection_id' => $selection->id,
            'category_id'  => $category->id,
        ]);

        factory(ProductCategorySelection::class)->create([
            'selection_id' => $selection->id,
            'category_id'  => $category2->id,
        ])->delete();

        $job = new BatchGammaDeactivation($category, $account, $brand);
        $job->handle(app(ProductSelection::class));

        $count = app('db')->table('product_gamma')->where([
            'account_id' => $account->id,
            'brand_id'   => $brand->id,
            'product_id' => $product->id,
        ])->count();

        $this->assertSame(1, $count);
    }
}
