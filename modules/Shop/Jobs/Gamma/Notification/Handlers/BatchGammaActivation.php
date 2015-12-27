<?php

namespace Modules\Shop\Jobs\Gamma\Notification\Handlers;

use App\Jobs\Job;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\Account;
use Modules\Shop\Gamma\GammaSelection;
use Modules\Shop\Jobs\Gamma\ActivateProduct;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\CatalogRepositoryInterface;
use Modules\Shop\Product\Category;

class BatchGammaActivation extends Job
{
    use DispatchesJobs;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Account
     */
    protected $account;

    /**
     * @var Brand
     */
    protected $brand;

    /**
     *
     *
     *
     */
    public function __construct(Category $category, Account $account, Brand $brand)
    {
        $this->category = $category;
        $this->account = $account;
        $this->brand = $brand;
    }

    /**
     *
     *
     */
    public function handle(CatalogRepositoryInterface $catalog, GammaSelection $gamma)
    {
        $this->insertGamma($gamma);

        $catalog->chunkWithinBrandCategory($this->account, $this->brand, $this->category, function ($products) {
            foreach ($products as $product) {
                $this->dispatch(new ActivateProduct($product, $this->category, $this->account));
            }
        });
    }

    /**
     *
     */
    protected function insertGamma(GammaSelection $gamma)
    {
        //insert this as a gamma selection
        $selected = $gamma->newInstance([
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'account_id' => $this->account->id,
        ]);

        $selected->save();
    }
}
