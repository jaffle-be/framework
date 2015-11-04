<?php namespace Modules\Shop\Http;

use Illuminate\Http\Request;
use Modules\Shop\Product\BrandTranslation;
use Modules\Shop\Product\CategoryTranslation;
use Modules\Shop\Product\Product;
use Modules\Shop\Product\ProductTranslation;
use Modules\System\Http\FrontController;

class ShopController extends FrontController
{

    /**
     * Shop home
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = Product::with(['translations', 'images', 'images.translations'])->get();

        $latest = $this->section($products, 4);

        $top = $this->section($products, 3);

        $bestsellers = $this->section($products, 3);

        $sales = $this->section($products, 3);

        $featured = $products;

        $tweets = latest_tweets_about(4);

        return $this->theme->render('shop.store', [
            'latest'      => $latest,
            'featured'    => $featured,
            'sales'       => $sales,
            'bestsellers' => $bestsellers,
            'top'         => $top,
            'tweets'      => $tweets
        ]);
    }

    public function category(CategoryTranslation $category, BrandTranslation $brand = null, Request $request)
    {
        $category = $category->category;
        $brand = $brand->brand;

        $defaults = [
            'count' => 20,
            'view'  => 'list',
        ];

        $filters = array_merge($defaults, $request->all());

        $products = \Modules\Shop\Product\Product::all();

        return $this->theme->render('shop.category-' . $filters['view'], ['products' => $products, 'category' => $category, 'filters' => $filters]);
    }

    public function product(ProductTranslation $product)
    {
        $product = $product->product;

        $product->load(['translations', 'images', 'images.translations']);

        return $this->theme->render('shop.product', ['product' => $product]);
    }

    protected function section($products, $int)
    {
        $result = $products->take($int);

        $products = $products->slice($int);

        return $result;
    }
}