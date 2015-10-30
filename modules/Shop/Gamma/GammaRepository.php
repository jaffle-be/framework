<?php namespace Modules\Shop\Gamma;

use Modules\Shop\Product\Brand;
use Modules\Shop\Product\Category;
use Modules\Shop\Product\Product;

class GammaRepository implements GammaRepositoryInterface
{
    protected $product;

    protected $category;

    protected $brand;

    public function __construct(Product $product, Category $category, Brand $brand)
    {
        $this->product = $product;
        $this->category = $category;
        $this->brand = $brand;
    }

    public function categoriesForBrand(Brand $brand)
    {
        $ids = $this->product->join('product_categories_pivot', 'products.id', '=', 'product_categories_pivot.product_id')
            ->where('brand_id', $brand->id)
            ->distinct(['category_id'])
            ->lists('category_id');

        return $this->category->whereIn('id', $ids)->get();
    }

    public function brandsForCategory(Category $category)
    {
        $ids = $this->product->join('product_categories_pivot', 'products.id', '=', 'product_categories_pivot.product_id')
            ->distinct(['brand_id'])
            ->where('category_id', $category->id)
            ->lists('brand_id');

        return $this->brand->whereIn('id', $ids)->get();
    }

}