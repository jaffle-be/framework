<?php namespace App\Dashboard\Http\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller{

    public function index()
    {
        return view('dashboard::start');
    }

}