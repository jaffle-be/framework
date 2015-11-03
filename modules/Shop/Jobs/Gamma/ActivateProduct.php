<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Account\Account;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;

class ActivateProduct extends Job implements SelfHandling
{

    protected $product;

    protected $categorie;

    protected $account;

    public function __construct(Product $product, Category $category, Account $account)
    {
        $this->product = $product;
        $this->category = $category;
        $this->account = $account;
    }

    public function handle(ProductSelection $selection)
    {
        $instance = $selection->newInstance([
            'account_id'  => $this->account->id,
            'product_id'  => $this->product->id,
            'brand_id'    => $this->product->brand_id,
            'category_id' => $this->category->id,
        ]);

        $instance->save();
    }

}