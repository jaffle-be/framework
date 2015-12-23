<?php namespace Modules\Shop\Product;

use Modules\Account\Account;

class CatalogRepository implements CatalogRepositoryInterface
{

    protected $product;

    protected $brand;

    protected $category;

    public function __construct(Product $product, Brand $brand, Category $category)
    {
        $this->product = $product;
        $this->brand = $brand;
        $this->category = $category;
    }

    public function findCategories(array $ids)
    {
        return $this->category->whereIn('id', $ids)->get();
    }

    public function findBrands(array $ids)
    {
        return $this->brand->whereIn('id', $ids)->get();
    }

    public function chunkWithinBrandCategory(Account $account, Brand $brand, Category $category, \Closure $callback)
    {
        $this->product->join('product_categories_pivot', 'products.id', '=', 'product_categories_pivot.product_id')
            ->where('category_id', $category->id)
            ->where('brand_id', $brand->id)
            ->chunk(100, $callback);
    }

}