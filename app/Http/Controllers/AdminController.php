<?php namespace App\Http\Controllers;

use App\Theme\ThemeManager;

class AdminController extends Controller
{

    public function __construct(ThemeManager $theme)
    {
        $this->middleware('auth.admin');

        parent::__construct($theme);
    }

}