<?php namespace App\Shop\Http\App\Admin;

use App\Http\Controllers\Controller;

class ProductController extends Controller{

    public function index()
    {
        return view('shop::admin.product.index');
    }

}