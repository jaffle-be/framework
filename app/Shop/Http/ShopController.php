<?php namespace App\Shop\Http;

use App\Http\Controllers\Controller;

class ShopController extends Controller
{

    public function index()
    {
        return view('shop::store');
    }

    public function show($categorySlug)
    {
        dd('category', $categorySlug);
    }

    public function product($productSlug)
    {
        return view('shop::product');
    }
}