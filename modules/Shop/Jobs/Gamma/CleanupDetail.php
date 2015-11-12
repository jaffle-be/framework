<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Account\Account;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;

class CleanupDetail extends Job implements SelfHandling, ShouldQueue
{

    /**
     * @var Brand
     */
    protected $brand;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Account
     */
    protected $account;

    public function __construct(Brand $brand, Category $category, Account $account)
    {
        $this->brand = $brand;
        $this->category = $category;
        $this->account = $account;
    }


    public function handle(GammaSelection $gamma, ProductSelection $products)
    {
        $params = [
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
        ];

        $selections = $products->withTrashed()->where($params)->get();

        foreach($selections as $selection)
        {
            $selection->forceDelete();
        }

        $selections = $gamma->where($params)->get();

        foreach($selections as $selection)
        {
            $selection->delete();
        }
    }

}