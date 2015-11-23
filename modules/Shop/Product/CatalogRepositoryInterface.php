<?php namespace Modules\Shop\Product;

use Modules\Account\Account;

interface CatalogRepositoryInterface
{

    public function findCategories(array $ids);

    public function findBrands(array $ids);

    public function chunkWithinBrandCategory(Account $account, Brand $brand, Category $category, \Closure $callback);

}