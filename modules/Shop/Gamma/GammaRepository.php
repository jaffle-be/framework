<?php

namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Collection;
use Modules\Shop\Product\Brand;
use Modules\Shop\Product\CatalogRepositoryInterface;
use Modules\Shop\Product\Category;

class GammaRepository implements GammaRepositoryInterface
{
    protected $brands;

    protected $categories;

    protected $catalog;

    public function __construct(BrandSelection $brands, CategorySelection $categories, CatalogRepositoryInterface $catalog)
    {
        $this->brands = $brands;
        $this->categories = $categories;
        $this->catalog = $catalog;
    }

    public function categoriesForBrand(Brand $brand)
    {
        $categories = $brand->categories;

        $ids = $categories->lists('id')->toArray();

        if (empty($ids)) {
            return new Collection();
        }

        //keep only categories selected by the account
        $ids = $this->categories->whereIn('category_id', $ids)->lists('category_id')->toArray();

        return $this->catalog->findCategories($ids);
    }

    public function brandsForCategory(Category $category)
    {
        $brands = $category->brands;

        $ids = $brands->lists('id')->toArray();

        if (empty($ids)) {
            return new Collection();
        }

        //keep only brands selected by the account
        $ids = $this->brands->whereIn('brand_id', $ids)->lists('brand_id')->toArray();

        return $this->catalog->findBrands($ids);
    }
}
