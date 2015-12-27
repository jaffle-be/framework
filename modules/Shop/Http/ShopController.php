<?php

namespace Modules\Shop\Http;

use Illuminate\Http\Request;
use Modules\Shop\Gamma\GammaQueryResolver;
use Modules\Shop\Product\BrandTranslation;
use Modules\Shop\Product\CategoryTranslation;
use Modules\Shop\Product\Product;
use Modules\Shop\Product\ProductTranslation;
use Modules\System\Http\FrontController;

/**
 * Class ShopController
 * @package Modules\Shop\Http
 */
class ShopController extends FrontController
{
    /**
     * Shop home.
     *
     *
     */
    public function index()
    {
        $products = Product::with(['translations', 'images', 'images.translations'])->take(15)->get();

        $latest = $this->section($products, 4);

        $top = $this->section($products, 3);

        $bestsellers = $this->section($products, 3);

        $sales = $this->section($products, 3);

        $featured = $products;

        $tweets = latest_tweets_about(4);

        return $this->theme->render('shop.store', [
            'latest' => $latest,
            'featured' => $featured,
            'sales' => $sales,
            'bestsellers' => $bestsellers,
            'top' => $top,
            'tweets' => $tweets,
        ]);
    }

    /**
     * @todo     remove brand from this route, it's not usefull
     *
     * $search
     * @param CategoryTranslation $category
     * @param BrandTranslation $brand
     * @param Request $request
     * @param GammaQueryResolver $resolver
     * @return \Illuminate\Contracts\View\View
     */
    public function category(CategoryTranslation $category, BrandTranslation $brand = null, Request $request, GammaQueryResolver $resolver)
    {
        $category = $category->category;

        $original = $category->original_id ? $category->originalCategory : $category;

        $original->load([
            'propertyGroups' => function ($query) {
                $query->whereHas('properties', function ($query) {
                    $query->where('type', '<>', 'string');
                });
            },
            'propertyGroups.translations',
            'propertyGroups.properties' => function ($query) {
                $query->where('type', '<>', 'string');
            },
            'propertyGroups.properties.translations',
        ]);

        //within this category, get the active brands for this client, use the given category, not the original

        $defaults = [
            'count' => 20,
            'view' => 'list',
        ];

        $filters = array_merge($defaults, $request->all());

        $results = $resolver->resolve($original, $category);

        return $this->theme->render('shop.category-'.$filters['view'], [
            'products' => $results['products'],
            'brands' => $results['brands'],
            'properties' => $results['properties'],
            'category' => $category,
            'original' => $original,
            'filters' => $filters,
        ]);
    }

    /**
     * @param ProductTranslation $product
     * @return \Illuminate\Contracts\View\View
     */
    public function product(ProductTranslation $product)
    {
        $product = $product->product;

        if (! $product) {
            abort(404);
        }

        $product->load(['translations', 'images', 'images.translations']);

        return $this->theme->render('shop.product', ['product' => $product]);
    }

    /**
     * @param $products
     * @param $int
     * @return mixed
     */
    protected function section($products, $int)
    {
        $result = $products->take($int);

        $products = $products->slice($int);

        return $result;
    }
}
