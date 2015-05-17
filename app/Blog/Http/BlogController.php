<?php namespace App\Blog\Http;

use App\Http\Controllers\Controller;

class BlogController extends Controller{

    public function index()
    {
        return view('blog::sidebar-right.large-overview-simple');
    }

    public function show()
    {
        return view('blog::full-width.large-detail');
    }

}