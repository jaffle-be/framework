<?php namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Collection;
use Modules\Account\Account;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;

interface GammaRepositoryInterface
{

    /**
     * @param Account $account
     * @param Brand   $brand
     *
     * @return Collection
     */
    public function categoriesForBrand(Brand $brand);

    public function brandsForCategory(Category $category);

}