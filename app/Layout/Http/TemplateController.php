<?php namespace App\Layout\Http;

use App\Http\Controllers\AdminController;
use Illuminate\Contracts\Auth\Guard;

class TemplateController extends AdminController
{

    public function template($template, Guard $guard)
    {
        $user = $guard->user();

        return view('layout::admin.' . $template, ['user' => $user]);
    }
}