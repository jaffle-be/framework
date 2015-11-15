<?php namespace Modules\Shop\Product;

interface CatalogRepositoryInterface
{

    public function findCategories(array $ids);

    public function findBrands(array $ids);

    public function chunkWithinBrandCategory(Brand $brand, Category $category, \Closure $callback);

}