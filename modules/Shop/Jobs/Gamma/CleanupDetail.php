<?php namespace Modules\Shop\Jobs\Gamma;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
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
        if ($this->shouldNotRun($products, $notifications)) {
            return;
        }

        $selections = $products
            ->newQueryWithoutScopes()
            ->join('product_gamma_categories', 'product_gamma_categories.selection_id', '=', 'product_gamma.id')
            ->where('account_id', $this->account->id)
            ->where('brand_id', $this->brand->id)
            ->where('category_id', $this->category->id)
            ->get(['product_gamma.*']);

        foreach ($selections as $selection) {
            $selections->load(['categories' => function ($query) {
                $query->withTrashed();
            }]);

            foreach ($selection->categories as $category) {
                $category->forceDelete();
            }

            $selection->forceDelete();
        }

        $selections = $gamma->newQueryWithoutScopes()
            ->where([
                'account_id'  => $this->account->id,
                'brand_id'    => $this->brand->id,
                'category_id' => $this->category->id
            ])->get();

        foreach ($selections as $selection) {
            $selection->delete();
        }
    }

    /**
     * @param ProductSelection  $products
     * @param GammaNotification $notifications
     *
     * @return bool
     */
    protected function shouldNotRun(ProductSelection $products, GammaNotification $notifications)
    {
        if ($products->countActiveProducts($this->brand->id, $this->category->id, $this->account->id) > 0) {
            return true;
        }

        $payload = [
            'brand_id'    => $this->brand->id,
            'category_id' => $this->category->id,
        ];

        if ($notifications->where($payload)->count()) {
            return true;
        }

        return false;
    }

}