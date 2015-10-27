<?php namespace Modules\Shop\Http\Admin;

use Modules\System\Http\AdminController;

class ProductController extends AdminController{

    public function index()
    {
        return view('shop::admin.product.index');
    }

}