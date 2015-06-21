<?php namespace App\Shop\Http\Store;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index()
    {
        return view('shop::store');
    }

    public function show($categorySlug, Request $request)
    {
        $view = $request->get('view', 'list');

        if (!in_array($view, ['list', 'grid'])) {
            $view = 'list';
        }

        $products = \App\Shop\Product\Product::all();

        return view('shop::category-' . $view, ['products' => $products]);
    }

    public function product($productSlug)
    {
        return view('shop::product');
    }
}