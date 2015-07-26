<?php namespace App\Marketing\Http\Admin;

use App\Http\Controllers\AdminController;

class MarketingController extends AdminController
{

    public function overview()
    {
        return view('marketing::admin.overview');
    }

}