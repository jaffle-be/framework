<?php namespace App\Dashboard\Http\App;

use App\Http\Controllers\Controller;

class DashboardController extends Controller{

    public function index()
    {
        return view('dashboard::start');
    }

}