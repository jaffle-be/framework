<?php namespace Test\Shop\Gamma;

use Illuminate\Bus\Dispatcher;
use Mockery as m;
use Modules\Account\Account;
use Modules\Account\AccountManager;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Jobs\Gamma\ActivateProduct;
use Modules\Shop\Jobs\Gamma\Notification\Handlers\BatchGammaActivation;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\CatalogRepositoryInterface;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;
use Test\TestCase;

class BatchGammaActivationTest extends TestCase
{

    public function testActivationWillActivateSystemProducts()
    {
        $system = Account::where('alias', 'digiredo')->first();

        list($account, $brand, $category) = $this->baseData();

        $this->products($brand, $system, $category);

        $this->needsActivationCommandsDispatched();

        $catalog = app(CatalogRepositoryInterface::class);
        $gamma = $this->gammaMock($account, $brand, $category);

        $job = new BatchGammaActivation($category, $account, $brand);
        $job->handle($catalog, $gamma);
    }

    public function testActivationWillActivateAccountProducts()
    {
        list($account, $brand, $category) = $this->baseData();

        $this->needsActivationCommandsDispatched();

        app(AccountManager::class)->forced($account, function() use ($account, $brand, $category)
        {
            $this->products($brand, $account, $category);

            $catalog = app(CatalogRepositoryInterface::class);
            $gamma = $this->gammaMock($account, $brand, $category);

            $job = new BatchGammaActivation($category, $account, $brand);
            $job->handle($catalog, $gamma);
        });
    }

    public function testTheGammaRecordGetsInserted()
    {
        list($account, $brand, $category) = $this->baseData();

        $job = new BatchGammaActivation($category, $account, $brand);

        $catalog = m::mock(CatalogRepositoryInterface::class);
        $catalog->shouldReceive('chunkWithinBrandCategory')->with($account, $brand, $category, $this->closureCheck())->once();

        $gamma = $this->gammaMock($account, $brand, $category);

        $job->handle($catalog, $gamma);
    }

    /**
     * @param $account
     * @param $brand
     * @param $category
     *
     * @return m\MockInterface
     */
    protected function gammaMock($account, $brand, $category)
    {
        $gamma = m::mock(GammaSelection::class);
        $gammaInstance = m::mock(GammaSelection::class);

        $gamma->shouldReceive('newInstance')->with([
            'account_id'  => $account->id,
            'brand_id'    => $brand->id,
            'category_id' => $category->id
        ])->andReturn($gammaInstance);

        $gammaInstance->shouldReceive('save');

        return $gamma;
    }

    /**
     * @return array
     */
    protected function baseData()
    {
        $account = factory(Account::class)->create();
        $brand = factory(Brand::class)->create();
        $category = factory(Category::class)->create();

        return array($account, $brand, $category);
    }

    /**
     * @param $brand
     * @param $account
     * @param $category
     */
    protected function products($brand, $account, $category)
    {
        $products = factory(Product::class)->times(2)->create([
            'brand_id'   => $brand->id,
            'account_id' => $account->id,
        ]);

        $products->each(function ($product) use ($category) {
            $product->categories()->attach($category);
        });
    }

    /**
     * @return m\Matcher\Closure
     */
    protected function closureCheck()
    {
        return m::on(function ($argument) {
            return $argument instanceof \Closure;
        });
    }

    protected function needsActivationCommandsDispatched()
    {
        $bus = m::mock(Dispatcher::class);
        $bus->shouldReceive('dispatch')->twice()->with(m::on(function ($job) {
            return get_class($job) == ActivateProduct::class;
        }));
        $this->app[Dispatcher::class] = $bus;
    }

}