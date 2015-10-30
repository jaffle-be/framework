<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Account\Account;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Product\Category;

class DeactivateCategory extends Job implements SelfHandling
{

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Account
     */
    protected $account;

    public function __construct(Category $category, Account $account)
    {

        $this->category = $category;
        $this->account = $account;
    }

    public function handle(ProductSelection $products)
    {
        $this->category->selection->delete();

        $selections = $products->where('category_id', $this->category->id)->get();

        foreach($selections as $selection)
        {
            $selection->delete();
        }
    }
}