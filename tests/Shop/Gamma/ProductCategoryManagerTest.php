<?php namespace Test\Shop\Gamma;

use DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Mockery as m;
use Modules\Account\Account;
use Modules\Shop\Jobs\Gamma\ActivateBrand;
use Modules\Shop\Jobs\Gamma\ActivateCategory;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;
use Test\AdminTestCase;

class ProductCategoryManagerTest extends AdminTestCase
{

    use DispatchesJobs;

    public function testAttachingShouldNotifyAllAccountsThatHaveThatCombinationSelected()
    {
        //just so we are sure we know exactly which getTestAccounts are linked and which are not
        //we'll use an entirely new brand-category combination.

        list($brand, $category, $product1, $product2) = $this->getTestBase();

        $product1->categories()->attach($category);

        //now make the selection for 3 getTestAccounts
        list($account1, $account2, $account3) = $this->getTestAccounts();

        //they can all 3 have the base selected
        $this->selectBases($brand, $account1, $account2, $account3, $category);

        //only 2 have the detail selected.
        $selection1 = $this->selectDetail($account1, $brand, $category, $product1);
        $selection2 = $this->selectDetail($account3, $brand, $category, $product1);

        $this->updateIndex();

        //now we'll manually attach the category to the other product and trigger the attach method
        $pivot1 = \DB::table('product_categories_pivot');
        $pivot1->insert([
            'product_id'  => $product2->id,
            'category_id' => $category->id,
        ]);

        $manager = app('Modules\Shop\Gamma\ProductCategoryManager');
        $manager->attach([
            'category_id' => $category->id,
            'product_id'  => $product2->id
        ]);

        //see notifications for both accounts with detail activated
        $this->seeInDatabase('product_gamma_notifications', [
            'account_id'  => $account1->id,
            'product_id'  => $product2->id,
            'brand_id'    => $brand->id,
            'category_id' => $category->id,
            'type'        => 'activate',
        ]);

        $this->seeInDatabase('product_gamma_notifications', [
            'account_id'  => $account3->id,
            'product_id'  => $product2->id,
            'brand_id'    => $brand->id,
            'category_id' => $category->id,
            'type'        => 'activate',
        ]);

        //not for the one that had it disabled
        $this->notSeeInDatabase('product_gamma_notifications', [
            'account_id'  => $account2->id,
            'product_id'  => $product2->id,
            'brand_id'    => $brand->id,
            'category_id' => $category->id,
            'type'        => 'activate',
        ]);
    }

    public function testDetachingTakesDownTheProductSelectionForThatCategory()
    {
        list($brand, $category, $product1, $product2) = $this->getTestBase();

        $product1->categories()->attach($category);
        $product2->categories()->attach($category);

        //now make the selection for 3 getTestAccounts
        list($account1, $account2, $account3) = $this->getTestAccounts();

        //they can all 3 have the base selected
        $this->selectBases($brand, $account1, $account2, $account3, $category);

        //only 2 have the detail selected.
        $selection1 = $this->selectDetail($account1, $brand, $category, $product1);
        $selection2 = $this->selectDetail($account3, $brand, $category, $product1);

        $this->updateIndex();

        \DB::table('product_categories_pivot')->where([
            'product_id'  => $product1->id,
            'category_id' => $category->id
        ])->delete();

        $manager = app('Modules\Shop\Gamma\ProductCategoryManager');
        $manager->detach([
            'category_id' => $category->id,
            'product_id'  => $product1->id
        ]);

        //account 1, 3 should be cleaned, but there basically shouldn't even be one record left.
        $count = \DB::table('product_gamma')
            ->join('product_gamma_categories', 'product_gamma.id', '=', 'product_gamma_categories.selection_id')
            ->where('product_id', $product1->id)
            ->where('category_id', $category->id)->count();

        $this->assertEquals(0, $count);
    }

    /**
     * @return array
     */
    protected function getTestBase()
    {
        $brand = factory(Brand::class)->create();
        $account = factory(Account::class)->create();
        $category = factory(Category::class)->create();

        $products = factory(Product::class)->times(2)->create([
            'brand_id' => $brand->id,
            'account_id' => $account->id
        ])->each(function($product) use ($category){
            $product->categories()->attach($category);
        });

        return array($brand, $category, $products->get(0), $products->get(1));
    }

    /**
     * @param $brand
     * @param $account1
     * @param $account2
     * @param $account3
     * @param $category
     */
    protected function selectBases($brand, $account1, $account2, $account3, $category)
    {
        $this->dispatch(new ActivateBrand($brand, $account1));
        $this->dispatch(new ActivateBrand($brand, $account2));
        $this->dispatch(new ActivateBrand($brand, $account3));
        $this->dispatch(new ActivateCategory($category, $account1));
        $this->dispatch(new ActivateCategory($category, $account2));
        $this->dispatch(new ActivateCategory($category, $account3));
    }

    /**
     * @return array
     */
    protected function getTestAccounts()
    {
        $account1 = factory(Account::class)->create();
        $account2 = factory(Account::class)->create();
        $account3 = factory(Account::class)->create();

        return array($account1, $account2, $account3);
    }

    /**
     * @param $account1
     * @param $brand
     * @param $category
     * @param $product1
     *
     * @return mixed
     */
    protected function selectDetail($account1, $brand, $category, $product1)
    {
        DB::table('product_gamma_selections')->insert([
            'account_id'  => $account1->id,
            'brand_id'    => $brand->id,
            'category_id' => $category->id,
        ]);

        $selection1 = DB::table('product_gamma')->insertGetId([
            'account_id' => $account1->id,
            'brand_id'   => $brand->id,
            'product_id' => $product1->id,
        ]);

        DB::table('product_gamma_categories')->insert([
            'selection_id' => $selection1,
            'category_id'  => $category->id
        ]);

        return $selection1;
    }

    protected function updateIndex()
    {
        //we manually created records to avoid all parts of our application to run.
        //but we now need to manually update the index so everything is in the state we want it to be.
        $search = app('Modules\Search\SearchServiceInterface');
        $search->build('product_gamma');
    }

}