<?php namespace App\Http\Controllers;

use App\Theme\Contracts\Theme;

class AdminController extends Controller
{

    public function __construct(Theme $theme)
    {
        $this->middleware('auth.admin');

        parent::__construct($theme);
    }

}