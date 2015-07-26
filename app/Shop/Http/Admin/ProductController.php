<?php namespace App\Shop\Http\Admin;

use App\Http\Controllers\AdminController;

class ProductController extends AdminController{

    public function index()
    {
        return view('shop::admin.product.index');
    }

}