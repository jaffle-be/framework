<?php namespace App\Shop\Http;

use App\Http\Controllers\Controller;
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

        return view('shop::category-' . $view);
    }

    public function product($productSlug)
    {
        return view('shop::product');
    }
}