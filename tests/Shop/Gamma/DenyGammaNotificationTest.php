<?php

namespace Test\Shop\Gamma;

use Mockery as m;
use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Gamma\ProductCategorySelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Jobs\Gamma\Notification\Handlers\DenyGammaNotification;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;
use Test\AdminTestCase;

class DenyGammaNotificationTest extends AdminTestCase
{
    public function testDenyingBatchActivation()
    {
        list($account_id, $brand_id, $category_id, $notification) = $this->startData(false, 'activate');

        $job = new DenyGammaNotification($notification);
        $this->handleJob($job);

        //for a batch activation,
        //also the count for following tables should be zero.
        $this->notSeeInDatabase('product_gamma', [
            'account_id' => $account_id,
        ]);
        //we don't need to check product_gamma_categories,
        //since it has a foreign key constraint to the product_gamma table
        //and we now already know it's empty
        $this->notSeeInDatabase('product_gamma_selections', [
            'account_id' => $account_id,
        ]);

        $this->notSeeInDatabase('product_gamma_notifications', [
            'id' => $notification->id,
        ]);
    }

    public function testDenyingProductActivation()
    {
        list($account_id, $brand_id, $category_id, $notification) = $this->startData(true, 'activate');

        //when denying a product, gamma selections should be on, or you woundn't be able to deny a product
        $gammaSelection = $this->database(new GammaSelection())
            ->insertGetId([
                'brand_id'    => $brand_id,
                'account_id'  => $account_id,
                'category_id' => $category_id,
            ]);

        //now deny the activation.
        $job = new DenyGammaNotification($notification);
        $this->handleJob($job);

        //for our activation, since nothing was selected, nothing should still be selected
        //it will also cleanup the actual gamma selection
        //also the count for following tables should be zero.
        $this->notSeeInDatabase('product_gamma', [
            'account_id' => $account_id,
        ]);
        //we don't need to check product_gamma_categories,
        //since it has a foreign key constraint to the product_gamma table
        //and we now already know it's empty
        $this->notSeeInDatabase('product_gamma_selections', [
            'account_id' => $account_id,
        ]);

        $this->notSeeInDatabase('product_gamma_notifications', [
            'id' => $notification->id,
        ]);
    }

    public function testDenyingABatchDeactivation()
    {
        list($account_id, $brand_id, $category_id, $notification, $products) = $this->setupForDeactivation(false);

        $job = new DenyGammaNotification($notification);
        $this->handleJob($job);

        //everything should still be there.
        $this->doDenyingDeactivationTest($account_id, $brand_id, $category_id, $products, $notification);
    }

    public function testDenyingAProductDeactivation()
    {
        list($account_id, $brand_id, $category_id, $notification, $products) = $this->setupForDeactivation(true);

        $job = new DenyGammaNotification($notification);
        $this->handleJob($job);

        $this->doDenyingDeactivationTest($account_id, $brand_id, $category_id, $products, $notification);
    }

    protected function startData($use_product, $status)
    {
        $brand = factory(Brand::class)->create();
        $account = factory(Account::class)->create();
        $category = factory(Category::class)->create();

        $products = factory(Product::class)->times(2)->create([
            'brand_id' => $brand->id,
            'account_id' => $account->id,
        ])->each(function ($product) use ($category) {
            $product->categories()->attach($category);
        });

        $notification = new GammaNotification([
            'brand_id'    => $brand->id,
            'category_id' => $category->id,
            'account_id'  => $account->id,
            'product_id'  => $use_product ? $products->first()->id : null,
            'status'      => $status,
        ]);

        return [$account->id, $brand->id, $category->id, $notification];
    }

    /**
     * @param $job
     */
    protected function handleJob($job)
    {
        $pusher = m::mock('Pusher');
        $pusher->shouldReceive('trigger');

        $job->handle($pusher, new GammaSelection());
    }

    /**
     * @return array
     */
    protected function setupForDeactivation($use_product)
    {
        list($account_id, $brand_id, $category_id, $notification) = $this->startData($use_product, 'deactivate');

        $products = Product::where([
            'brand_id' => $brand_id,
        ])->get();

        $this->database(new GammaSelection())->insert([
            'account_id'  => $account_id,
            'brand_id'    => $brand_id,
            'category_id' => $category_id,
        ]);

        foreach ($products as $product) {
            $id = $this->database(new ProductSelection())->insertGetId([
                'account_id' => $account_id,
                'brand_id'   => $brand_id,
                'product_id' => $product->id,
            ]);

            $this->database(new ProductCategorySelection())->insert([
                'selection_id' => $id,
                'category_id'  => $category_id,
            ]);
        }

        return [$account_id, $brand_id, $category_id, $notification, $products];
    }

    /**
     * @param $account_id
     * @param $brand_id
     * @param $category_id
     * @param $products
     * @param $notification
     */
    protected function doDenyingDeactivationTest($account_id, $brand_id, $category_id, $products, $notification)
    {
        $recordcount = $this->database(new ProductSelection())
            ->join('product_gamma_categories', 'product_gamma_categories.selection_id', '=', 'product_gamma.id')
            ->where([
                'account_id'  => $account_id,
                'brand_id'    => $brand_id,
                'category_id' => $category_id,
            ])->count();

        $this->assertEquals($products->count(), $recordcount);

        $this->seeInDatabase('product_gamma_selections', [
            'brand_id'    => $brand_id,
            'category_id' => $category_id,
            'account_id'  => $account_id,
        ]);

        $this->notSeeInDatabase('product_gamma_notifications', [
            'id' => $notification->id,
        ]);
    }
}
