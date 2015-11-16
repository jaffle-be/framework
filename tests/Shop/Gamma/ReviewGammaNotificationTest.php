<?php namespace Shop\Gamma;

use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Gamma\ProductCategorySelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Jobs\Gamma\Notification\Handlers\ReviewGammaNotification;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;
use Test\AdminTestCase;

class ReviewGammaNotificationTest extends AdminTestCase
{

    public function testReviewingBatchActivation()
    {
        //the review should basically create a notification for each product within those parameters.
        //but it should also already have the record? or do we wait until the review is accepted?
        list($category_id, $account_id, $brand_id, $notification) = $this->startData();

        $job = new ReviewGammaNotification($notification);
        $this->handleJob($job);

        //new account -> should not contain gamma
        // -> should have the selection
        // -> should have the notifications for products

        $products = Product::where('brand_id', $brand_id)
            ->whereHas('categories', function ($q) use ($category_id) {
                $q->where('category_id', $category_id);
            });

        foreach ($products as $product) {
            $this->seeInDatabase('product_gamma_notifications', [
                'product_id'  => $product->id,
                'brand_id'    => $product->brand_id,
                'category_id' => $category_id,
                'account_id'  => $account_id,
                'type'        => 'activate',
            ]);

            $this->notSeeInDatabase('product_gamma', [
                'product_id' => $product->id,
                'account_id' => $account_id,
            ]);
        }

        $this->seeInDatabase('product_gamma_selections', [
            'account_id'  => $account_id,
            'category_id' => $category_id,
            'brand_id'    => $brand_id,
        ]);

        $this->notSeeInDatabase('product_gamma_notifications', [
            'id' => $notification->id
        ]);
    }

    public function testReviewingBatchDeactivation()
    {
        //when deactivating, only notifications should be shown for products not already inactive.
        $account = factory(Account::class)->create();
        $brand = factory(Brand::class)->create();
        $product1 = factory(Product::class)->create([
            'brand_id' => $brand->id
        ]);
        $product2 = factory(Product::class)->create([
            'brand_id' => $brand->id
        ]);
        $category = factory(Category::class)->create();

        $product1->categories()->attach($category);
        $product2->categories()->attach($category);

        factory(GammaSelection::class)->create([
            'account_id'  => $account->id,
            'brand_id'    => $brand->id,
            'category_id' => $category->id,
        ]);

        //product1 was selected
        $selection = factory(ProductSelection::class)->create([
            'account_id'  => $account->id,
            'brand_id'    => $brand->id,
            'product_id' => $product1->id
        ]);

        $selection->categories()->save(factory(ProductCategorySelection::class)->make([
            'category_id' => $category->id
        ]));

        //product2 not
        $selection = factory(ProductSelection::class, 'deleted')->create([
            'account_id'  => $account->id,
            'brand_id'    => $brand->id,
            'product_id' => $product2->id,
        ]);

        $selection->categories()->save(factory(ProductCategorySelection::class, 'deleted')->make([
            'category_id' => $category->id
        ]));

        $notification = factory(GammaNotification::class, 'deactivate')->create([
            'account_id' => $account->id,
            'brand_id' => $brand->id,
            'category_id' => $category->id,
        ]);

        $job = new ReviewGammaNotification($notification);
        $this->handleJob($job);

        //original notification is gone
        $this->notSeeInDatabase('product_gamma_notifications', [
            'id' => $notification->id
        ]);

        //should only see notification for product 1
        $this->seeInDatabase('product_gamma_notifications', [
            'account_id' => $account->id,
            'product_id' => $product1->id,
            'type' => 'deactivate',
            'brand_id'    => $brand->id,
            'category_id' => $category->id
        ]);

        $this->notSeeInDatabase('product_gamma_notifications', [
            'account_id' => $account->id,
            'product_id' => $product2->id,
        ]);

        //gamma selection should be untouched?
        $this->seeInDatabase('product_gamma_selections', [
            'account_id' => $account->id,
            'brand_id' => $brand->id,
            'category_id' => $category->id
        ]);

        //product selections should still be the same
        $query = $this->database(new ProductSelection());
        $test1 = $query->join('product_gamma_categories', 'product_gamma_categories.selection_id', '=', 'product_gamma.id')
            ->where('product_id', $product1->id)
            ->whereNull('product_gamma.deleted_at')
            ->whereNull('product_gamma_categories.deleted_at')
            ->count();

        $query = $this->database(new ProductSelection());
        $test1 = $query->join('product_gamma_categories', 'product_gamma_categories.selection_id', '=', 'product_gamma.id')
            ->where('product_id', $product2->id)
            ->whereNotNull('product_gamma.deleted_at')
            ->whereNotNull('product_gamma_categories.deleted_at')
            ->count();

        $this->assertSame(1, $test1);
        $this->assertSame(1, $test1);
    }

    public function startData()
    {
        $product = Product::first();
        $account = factory(Account::class)->create();
        $category_id = $product->categories->first()->id;
        $account_id = $account->id;
        $brand_id = $product->brand_id;

        //create notification
        $notification = new GammaNotification([
            'account_id'  => $account_id,
            'brand_id'    => $brand_id,
            'category_id' => $category_id,
            'type'        => 'activate',
        ]);

        $notification->save();

        return array($category_id, $account_id, $brand_id, $notification);
    }

    protected function handleJob(ReviewGammaNotification $job)
    {
        $job->handle(new GammaSelection(), app('Pusher'), app('Modules\Shop\Product\CatalogRepositoryInterface'), new ProductSelection(), new GammaNotification());
    }

}