<?php namespace System\Eventing;

use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;
use Modules\System\Eventing\BelongsToMany;
use Test\AdminTestCase;

class BelongsToManyTest extends AdminTestCase
{

    public function testAttachingOneInstanceUsingIdMethod()
    {
        $product = $this->product();

        $relation = $this->relationToTest($product);

        $category = factory(Category::class)->create();

        $mock = $this->spy();
        $this->app->instance('events', $mock);

        $this->expectAttached($mock, $product, $category);

        $relation->attach($category->id);
    }

    public function testAttachingOneInstanceUsingModelMethod()
    {
        $product = $this->product();

        $relation = $this->relationToTest($product);

        $category = factory(Category::class)->create();

        $mock = $this->spy();
        $this->app->instance('events', $mock);

        $this->expectAttached($mock, $product, $category);

        $relation->attach($category);
    }

    public function testAttachingOneUsingSyncWithArrayMethod()
    {
        $product = $this->product();
        $category = factory(Category::class)->create();

        $relation = $this->relationToTest($product);

        $mock = $this->spy();
        $this->app->instance('events', $mock);

        $this->expectAttached($mock, $product, $category);

        $relation->sync([$category->id]);
    }

    public function testAttachingOneUsingSyncWithCollectionMethod()
    {
        $product = $this->product();
        $category = factory(Category::class)->create();

        $relation = $this->relationToTest($product);

        $mock = $this->spy();
        $this->app->instance('events', $mock);

        $this->expectAttached($mock, $product, $category);

        $collection = new Collection([$category]);

        $relation->sync($collection);
    }

    public function testAttachingMultipleOnesUsingSyncArrayMethod()
    {
        $product = $this->product();
        $category1 = factory(Category::class)->create();
        $category2 = factory(Category::class)->create();

        $relation = $this->relationToTest($product);

        $mock = $this->spy();

        $this->app->instance('events', $mock);

        $this->expectAttached($mock, $product, $category1);
        $this->expectAttached($mock, $product, $category2);

        $relation->sync([$category1->id, $category2->id]);
    }

    public function testAttachingMultipleOnesUsingSyncCollectionMethod()
    {
        $product = $this->product();
        $category1 = factory(Category::class)->create();
        $category2 = factory(Category::class)->create();

        $relation = $this->relationToTest($product);

        $mock = $this->spy();
        $this->expectAttached($mock, $product, $category1);
        $this->expectAttached($mock, $product, $category2);

        $this->app->instance('events', $mock);

        $collection = new Collection([$category1, $category2]);

        $relation->sync($collection);
    }

    public function testDetachingUsingIdMethod()
    {
        $product = $this->product();
        $category = factory(Category::class)->create();
        $product->categories()->attach($category);

        $relation = $this->relationToTest($product);

        $mock = $this->spy();

        $this->expectDetached($mock, $product, $category);

        $this->app->instance('events', $mock);

        $relation->detach($category->id);
    }

    public function testDetachingUsingModelMethod()
    {
        $product = $this->product();
        $category = factory(Category::class)->create();
        $product->categories()->attach($category);

        $relation = $this->relationToTest($product);

        $mock = $this->spy();

        $this->expectDetached($mock, $product, $category);

        $this->app->instance('events', $mock);

        $relation->detach($category);
    }

    public function testDetachingMultiplesUsingArrayMethod()
    {
        $product = $this->product();
        $category1 = factory(Category::class)->create();
        $category2 = factory(Category::class)->create();
        $product->categories()->attach($category1);
        $product->categories()->attach($category2);

        $relation = $this->relationToTest($product);

        $mock = $this->spy();

        $this->expectDetached($mock, $product, $category1);
        $this->expectDetached($mock, $product, $category2);

        $this->app->instance('events', $mock);

        $relation->detach([$category1->id, $category2->id]);
    }

    public function testDetachingOneUsingSyncMethod()
    {
        $product = $this->product();
        $category = factory(Category::class)->create();
        $product->categories()->attach($category);

        $relation = $this->relationToTest($product);

        $mock = $this->spy();

        $this->expectDetached($mock, $product, $category);

        $this->app->instance('events', $mock);

        $relation->sync([]);
    }

    public function testDetachingMultipleUsingSyncMethod()
    {
        $product = $this->product();
        $category1 = factory(Category::class)->create();
        $category2 = factory(Category::class)->create();
        $product->categories()->attach($category1);
        $product->categories()->attach($category2);

        $relation = $this->relationToTest($product);

        $mock = $this->spy();

        $this->expectDetached($mock, $product, $category1);
        $this->expectDetached($mock, $product, $category2);

        $this->app->instance('events', $mock);

        $relation->sync([]);
    }

    public function testSyncingAddsUnaddedInstancesAndRemovesInstancesThatShouldBeRemoved()
    {
        $product = $this->product();
        $category1 = factory(Category::class)->create();
        $category2 = factory(Category::class)->create();
        $category3 = factory(Category::class)->create();
        $product->categories()->attach($category1);
        $product->categories()->attach($category2);

        $relation = $this->relationToTest($product);

        $mock = $this->spy();

        $this->expectAttached($mock, $product, $category3);
        $this->expectDetached($mock, $product, $category2);
        $mock->shouldNotHaveReceived('fire', [
            'illuminate.attached: test_relation',
            [['product_id' => $product->id, 'category_id' => $category1->id]]
        ]);

        $this->app->instance('events', $mock);

        //we want 1 and 3 to be linked, 2 will not be
        //meaning that there should be NO event for category1.
        //for category 3 we need an attach event
        //for category 2 we need a detach event
        $relation->sync([$category1->id, $category3->id]);
    }

    protected function relationToTest($product)
    {
        $category = new Category();

        return new BelongsToMany($category->newQuery(), $product, 'product_categories_pivot', 'product_id', 'category_id', 'test_relation');
    }

    /**
     * @return mixed
     */
    protected function product()
    {
        $brand = factory(Brand::class)->create();
        $product = factory(Product::class)->create([
            'account_id' => $this->account()->id,
            'brand_id'   => $brand->id,
        ]);

        return $product;
    }

    /**
     * @param $mock
     * @param $product
     * @param $category1
     */
    protected function expectAttached($mock, $product, $category)
    {
        $mock->shouldReceive('fire')
            ->once()
            ->with('eloquent.attached: test_relation', [['product_id' => $product->id, 'category_id' => $category->id]]);
    }

    protected function expectDetached($mock, $product, $category)
    {
        $mock->shouldReceive('fire')
            ->once()
            ->with('eloquent.detached: test_relation', Mockery::on(function ($value) use ($product, $category) {

                $check = $value[0];

                if (!array_key_exists('product_id', $check) || $check['product_id'] != $product->id) {
                    return false;
                }

                if (!array_key_exists('product_id', $check) || $check['product_id'] != $product->id) {
                    return false;
                }

                return true;
            }));
    }

    /**
     * @return Mockery\MockInterface
     */
    protected function spy()
    {
        return Mockery::spy('Illuminate\Contracts\Events\Dispatcher');
    }

}