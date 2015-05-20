<?php namespace App\Blog\Http\Admin;

use App\Http\Controllers\Controller;

class BlogController extends Controller{

    public function index()
    {
        return view('blog::admin.index');
    }

    public function show()
    {
        return view('blog::admin.show');
    }

}