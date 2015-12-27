<?php

namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Collection;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;

interface GammaRepositoryInterface
{
    /**
     * @return Collection
     * @internal param Account $account
     */
    public function categoriesForBrand(Brand $brand);

    public function brandsForCategory(Category $category);
}
