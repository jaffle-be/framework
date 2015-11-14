<?php namespace Shop\Gamma;

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

class ProductCategoryManagerFrontTest extends AdminTestCase
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

        \DB::table('product_categories_pivot')->where([
            'product_id' => $product1->id,
            'category_id' => $category->id
        ])->delete();


        $manager = app('Modules\Shop\Gamma\ProductCategoryManager');
        $manager->detach([
            'category_id' => $category->id,
            'product_id' => $product1->id
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
        $brand = Brand::create([]);

        $category = Category::create([]);

        $product1 = new Product();
        $product1->brand_id = $brand->id;
        $product1->save();

        $product2 = new Product();
        $product2->brand_id = $brand->id;
        $product2->save();

        return array($brand, $category, $product1, $product2);
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
        $account1 = Account::create([]);
        $account2 = Account::create([]);
        $account3 = Account::create([]);

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

}