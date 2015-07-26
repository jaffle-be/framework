<?php namespace App\Dashboard\Http\Admin;

use App\Http\Controllers\AdminController;

class DashboardController extends AdminController
{

    public function index()
    {
        return 'dashboard';
    }

}