<?php namespace Modules\Shop\Http;

use Illuminate\Http\Request;
use Modules\Shop\Product\Product;
use Modules\System\Http\FrontController;

class ShopController extends FrontController
{

    public function index()
    {
        return $this->theme->render('shop.store');
    }

    public function show($categorySlug, Request $request)
    {
        $view = $request->get('view', 'list');

        if (!in_array($view, ['list', 'grid'])) {
            $view = 'list';
        }

        $products = \Modules\Shop\Product\Product::all();

        return $this->theme->render('shop.category-' . $view, ['products' => $products]);
    }

    public function product($productSlug, Product $product)
    {
        $product = $product->first();

        return $this->theme->render('shop.product', ['product' => $product]);
    }
}