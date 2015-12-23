<?php namespace Modules\Shop\Gamma;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\Account;
use Modules\Shop\Jobs\Gamma\DeactivateProduct;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;

class ProductCategoryManager
{

    use DispatchesJobs;

    public function __construct(GammaSelection $gamma, ProductSelection $selections, Product $product, Category $category, Account $account, GammaNotification $notifications)
    {
        $this->gamma = $gamma;
        $this->selections = $selections;
        $this->product = $product;
        $this->category = $category;
        $this->account = $account;
        $this->notifications = $notifications;
    }

    public function attach($payload)
    {
        //when attaching a category, need to make sure people with this selected are notified
        $category = $this->category->find($payload['category_id']);
        $product = $this->product->newQueryWithoutScopes()->find($payload['product_id']);

        $selections = $this->records($product, $category);

        foreach ($selections as $selection) {
            $this->notify($selection->account_id, $product, $category->id, 'activate');
        }
    }

    public function detach($payload)
    {
        $category_id = $payload['category_id'];

        $product = $this->product->newQueryWithoutScopes()->find($payload['product_id']);
        $category = $this->category->find($payload['category_id']);

        $records = $this->records($product, $category);

        foreach ($records as $record) {
            $account = $this->account->find($record->account_id);

            $this->dispatch(new DeactivateProduct($product, $category, $account));

            //deactivating the product will not be enough, we also need the record deleted
            $instance = $this->selections->newQueryWithoutScopes()
                ->where([
                    'product_id' => $product->id,
                    'brand_id'   => $product->brand_id,
                    'account_id' => $record->account_id,
                ])->first();

            if ($instance) {
                $categorySelection = $instance->categories()
                    ->withTrashed()
                    ->where('category_id', $category_id)
                    ->first();

                if ($categorySelection) {
                    $categorySelection->forceDelete();
                }

                if ($this->otherCategories($instance)) {
                    $instance->forceDelete();
                }
            }
        }
    }

    /**
     * actions should run for all accounts
     * therefor -> we should use the table to query,
     * not the eloquent instance
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function records($product, $category)
    {
        $query = $this->gamma->newQueryWithoutScopes();

        return $query
            ->where('brand_id', $product->brand_id)
            ->where('category_id', $category->id)
            ->get();
    }

    protected function notify($accountid, $product, $category_id, $status)
    {
        $this->notifications->create([
            'account_id'  => $accountid,
            'product_id'  => $product->id,
            'category_id' => $category_id,
            'brand_id'    => $product->brand_id,
            'type'        => $status
        ]);
    }

    /**
     * @param ProductSelection $instance
     *
     * @return bool
     */
    protected function otherCategories(ProductSelection $instance)
    {
        $query = $instance->newQueryWithoutScopes();

        $query->join('product_gamma_categories', 'product_gamma_categories.selection_id', '=', 'product_gamma.id')
            ->where('product_gamma.id', $instance->id);

        return $query->count() == 0;
    }

}