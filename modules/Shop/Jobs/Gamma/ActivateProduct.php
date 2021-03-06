<?php

namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Modules\Account\Account;
use Modules\Shop\Gamma\ProductCategorySelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;

/**
 * Class ActivateProduct
 * @package Modules\Shop\Jobs\Gamma
 */
class ActivateProduct extends Job
{
    protected $product;

    protected $categorie;

    protected $account;

    /**
     * @param Product $product
     * @param Category $category
     * @param Account $account
     */
    public function __construct(Product $product, Category $category, Account $account)
    {
        $this->product = $product;
        $this->category = $category;
        $this->account = $account;
    }

    /**
     * @param ProductSelection $products
     */
    public function handle(ProductSelection $products)
    {
        $base = $this->baseSelectionExists($products);

        if (! $base) {
            $this->handleFullNewRecord($products);
        } else {
            $selection = $this->existingCategorySelection($base);

            if ($selection) {
                if ($selection->trashed()) {
                    $selection->restore();
                }
            } else {
                $this->attachCategory($base);
            }

            if ($base->trashed()) {
                $base->restore();
            }
        }
        //now continue with updating the prices.
    }

    /**
     * @param ProductSelection $selection
     * @return
     */
    protected function baseSelectionExists(ProductSelection $selection)
    {
        return $selection->where('product_id', $this->product->id)
            ->where('brand_id', $this->product->brand_id)
            ->withTrashed()
            ->first();
    }

    /**
     * @param ProductSelection $base
     */
    protected function attachCategory(ProductSelection $base)
    {
        $base->categories()->save(new ProductCategorySelection([
            'category_id' => $this->category->id,
        ]));
    }

    /**
     * @param ProductSelection $products
     */
    protected function handleFullNewRecord(ProductSelection $products)
    {
        $base = $products->create([
            'account_id' => $this->account->id,
            'product_id' => $this->product->id,
            'brand_id' => $this->product->brand_id,
        ]);

        $this->attachCategory($base);
    }

    /**
     * @param ProductSelection $base
     * @return
     */
    protected function existingCategorySelection(ProductSelection $base)
    {
        $selection = $base->categories()
            ->where('category_id', $this->category->id)
            ->withTrashed()
            ->first();

        return $selection;
    }
}
