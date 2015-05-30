<?php namespace App\Layout\Http;

use App\Http\Controllers\Controller;

class TemplateController extends Controller
{

    public function template($template)
    {
        return view('layout::admin.' . app_detect() . '.' . $template);
    }
}