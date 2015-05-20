<?php namespace App\Layout\Http;

use App\Http\Controllers\Controller;

class TemplateController extends Controller{

    public function show($template)
    {
        return view('layout::admin.templates.' . $template);
    }

}