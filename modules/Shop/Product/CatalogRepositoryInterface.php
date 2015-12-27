<?php

namespace Modules\Shop\Product;

use Modules\Account\Account;

/**
 * Interface CatalogRepositoryInterface
 * @package Modules\Shop\Product
 */
interface CatalogRepositoryInterface
{
    /**
     * @param array $ids
     * @return mixed
     */
    public function findCategories(array $ids);

    /**
     * @param array $ids
     * @return mixed
     */
    public function findBrands(array $ids);

    /**
     * @param Account $account
     * @param Brand $brand
     * @param Category $category
     * @param \Closure $callback
     * @return mixed
     */
    public function chunkWithinBrandCategory(Account $account, Brand $brand, Category $category, \Closure $callback);
}
