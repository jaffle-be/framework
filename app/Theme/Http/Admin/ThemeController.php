<?php namespace App\Theme\Http\Admin;

use App\Http\Controllers\Controller;
use App\Theme\ThemeRepository;

class ThemeController extends Controller
{

    public function settings()
    {
        return view('theme::admin.settings');
    }

}