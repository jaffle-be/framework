<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Account\Account;
use Modules\Shop\Gamma\GammaNotification;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;

class CleanupDetail extends Job implements SelfHandling
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


    public function handle(GammaSelection $gamma, ProductSelection $products, GammaNotification $notifications)
    {
        if($notifications->where([
            'brand_id' => $this->brand->id,
            'category_id' => $this->category->id,
        ])->count())
        {
            return;
        }

        $selections = $products
            ->join('product_gamma_categories', 'product_gamma_categories.selection_id', '=', 'product_gamma.id')
            ->withTrashed()
            ->where('brand_id', $this->brand->id)
            ->where('category_id', $this->category->id)
            ->get(['product_gamma.*']);

        foreach($selections as $selection)
        {
            $selections->load(['categories' => function($query){
                $query->withTrashed();
            }]);

            foreach($selection->categories as $category)
            {
                $category->forceDelete();
            }

            $selection->forceDelete();
        }

        $selections = $gamma->where([
            'brand_id' => $this->brand->id,
            'category_id' => $this->category->id
        ])->get();

        foreach($selections as $selection)
        {
            $selection->delete();
        }
    }

}