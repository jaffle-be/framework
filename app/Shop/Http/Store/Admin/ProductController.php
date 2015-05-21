<?php namespace App\Shop\Http\Store\Admin;

use App\Http\Controllers\Controller;

class ProductController extends Controller{

    public function index()
    {
        return view('shop::admin.product.index');
    }

}