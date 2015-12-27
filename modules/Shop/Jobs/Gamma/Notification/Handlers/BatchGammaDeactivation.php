<?php

namespace Modules\Shop\Jobs\Gamma\Notification\Handlers;

use App\Jobs\Job;
use Modules\Account\Account;
use Modules\Shop\Gamma\ProductSelection;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;

class BatchGammaDeactivation extends Job
{

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
     */
    public function __construct(Category $category, Account $account, Brand $brand)
    {
        $this->category = $category;
        $this->account = $account;
        $this->brand = $brand;
    }

    public function handle(ProductSelection $productGamma)
    {
        //chunk alike thinking here
        while ($productGamma->countActiveProducts($this->brand->id, $this->category->id, $this->account->id) > 0) {
            $selections = $this->loadSelections($productGamma);

            foreach ($selections as $selection) {
                $category = $selection->categories->first(function ($key, $item) {
                    return $item->category_id == $this->category->id;
                });

                $category->delete();

                $active = $selection->categories->filter(function ($item) {
                    return !$item->trashed();
                });

                if ($active->count() == 0) {
                    $selection->delete();
                }
            }
        }
    }

    /**
     * @return mixed
     */
    protected function loadSelections(ProductSelection $productGamma)
    {
        $selections = $productGamma->chunkActiveProducts($this->brand->id, $this->category->id, $this->account->id);

        $selections->load([
            'categories' => function ($query) {
                $query->withTrashed();
            }
        ]);

        return $selections;
    }
}
