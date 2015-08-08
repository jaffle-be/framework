<?php namespace App\Shop\Http;

use App\System\Http\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
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

        $products = \App\Shop\Product\Product::all();

        return $this->theme->render('shop.category-' . $view, ['products' => $products]);
    }

    public function product($productSlug)
    {
        return $this->theme->render('shop.product');
    }
}