<?php

namespace Modules\Shop\Gamma;

use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;

/**
 * Interface GammaRepositoryInterface
 * @package Modules\Shop\Gamma
 */
interface GammaRepositoryInterface
{
    /**
     *
     * $account
     * @param Brand $brand
     * @return
     */
    public function categoriesForBrand(Brand $brand);

    /**
     * @param Category $category
     * @return mixed
     */
    public function brandsForCategory(Category $category);
}
