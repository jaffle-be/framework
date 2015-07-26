<?php namespace App\Theme\Http\Admin;

use App\Http\Controllers\AdminController;

class ThemeController extends AdminController
{

    public function settings()
    {
        return view('theme::admin.settings');
    }

}