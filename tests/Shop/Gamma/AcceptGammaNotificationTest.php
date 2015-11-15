<?php namespace Shop\Gamma;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Jobs\Gamma\ActivateProduct;
use Modules\Shop\Jobs\Gamma\CleanupDetail;
use Modules\Shop\Jobs\Gamma\DeactivateProduct;
use Modules\Shop\Jobs\Gamma\Notification\Handlers\AcceptGammaNotification;
use Modules\Shop\Product\Product;
use Test\AdminTestCase;
use Mockery as m;

class AcceptGammaNotificationTest extends AdminTestCase
{
    use DispatchesJobs;

    public function testAcceptingABatchActivation()
    {
        list($category_id, $account_id, $brand_id, $notification) = $this->startDataActivation();

        //when batch accepting a notification, we need to add the gamma selection
        //and add all products that exist for that gamma combination.
        //so we can test by counting rows

        //how many products have this combination?
        $amount = Product::where('brand_id', $brand_id)
            ->whereHas('categories', function($query) use ($category_id){
                $query->where('id', $category_id);
            })->count();


        $job = new AcceptGammaNotification($notification);
        $this->handleJob($job);

        //now we need to see the same amount of rows in our product_gamma table

        $payload = ['account_id' => $account_id, 'brand_id' => $brand_id];
        $this->seeInDatabase('product_gamma', $payload);
        $this->seeInDatabase('product_gamma_selections', $payload);
        $this->assertSame($amount, $this->database(new ProductSelection())->where($payload)->count());
        //since we have a new account, we are 100% sure there should be no other records.
        $this->assertSame(0, $this->database(new ProductSelection())->where('account_id', $account_id)->where('brand_id', '<>', $brand_id)->count());
        $this->assertSame(0, $this->database(new GammaSelection())->where('account_id', $account_id)->where('brand_id', '<>', $brand_id)->count());
    }


    public function testAcceptingAProductActivation()
    {
        $notification = new GammaNotification([
            'product_id' => 1,
            'account_id' => 1,
            'brand_id' => 1,
            'category_id' => 1,
            'type' => 'activate',
        ]);

        $notification->save();

        $this->expectsJobs([ActivateProduct::class, CleanupDetail::class]);

        $job = new AcceptGammaNotification($notification);
        $this->handleJob($job);
    }

    public function testAcceptingABatchDeactivation()
    {
        list($category_id, $account_id, $brand_id, $notification) = $this->startDataDeactivation();

        $search = app('Modules\Search\SearchServiceInterface');
        $search->build('product_gamma');

        $job = new AcceptGammaNotification($notification);
        $this->handleJob($job);

        //when ready we should see no rows in product_gamma and product_gamma_categories
        $query = $this->database(new ProductSelection());

        $amount = $query->join('product_gamma_categories', 'product_gamma_categories.selection_id', '=', 'product_gamma.id')
            ->where('brand_id', $brand_id)
            ->where('category_id', $category_id)
            ->where('account_id', $account_id)
            ->count();

        $this->assertEquals(0, $amount);
    }

    public function testAcceptingAProductDeactivation()
    {
        $notification = new GammaNotification([
            'product_id' => 1,
            'account_id' => 1,
            'brand_id' => 1,
            'category_id' => 1,
            'type' => 'deactivate',
        ]);

        $notification->save();

        $this->expectsJobs([DeactivateProduct::class, CleanupDetail::class]);

        $job = new AcceptGammaNotification($notification);
        $this->handleJob($job);
    }

    /**
     * @return array
     */
    protected function startDataActivation()
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

    protected function startDataDeactivation()
    {
        $product = Product::first();
        $account = factory(Account::class)->create();
        $category_id = $product->categories->first()->id;
        $account_id = $account->id;
        $brand_id = $product->brand_id;


        $products = Product::where('brand_id', $product->brand_id)
            ->whereHas('categories', function($q) use ($category_id){
                $q->where('id', $category_id);
            })
                ->get();

        foreach($products as $product)
        {
            //create selections
            $selection = \DB::table('product_gamma')->insertGetId([
                'account_id' => $account->id,
                'brand_id' => $brand_id,
                'product_id' => $product->id
            ]);

            \DB::table('product_gamma_categories')->insert([
                'category_id' => $category_id,
                'selection_id' => $selection
            ]);

            \DB::table('product_gamma_selections')->insert([
                'account_id' => $account_id,
                'category_id' => $category_id,
                'brand_id' => $brand_id
            ]);
        }


        //create the notification
        $notification = new GammaNotification([
            'account_id'  => $account_id,
            'brand_id'    => $brand_id,
            'category_id' => $category_id,
            'type'        => 'deactivate',
        ]);

        $notification->save();

        return array($category_id, $account_id, $brand_id, $notification);
    }

    protected function handleJob($job)
    {
        $pusher = m::mock('Pusher');
        $pusher->shouldReceive('trigger');
        $job->handle(app('Modules\Shop\Product\CatalogRepositoryInterface'), new GammaSelection(), new ProductSelection(), $pusher);
    }

}