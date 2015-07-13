<?php namespace App\Marketing\Http\Admin;

use App\Http\Controllers\Controller;

class MarketingController extends Controller
{

    public function overview()
    {
        return view('marketing::admin.overview');
    }

}