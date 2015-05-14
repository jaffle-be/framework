<?php namespace App\Http\Controllers;

class
WelcomeController extends Controller
{

    public function index()
    {
        return view('home');
    }

    public function start()
    {
        return view('layouts.back');
    }

}
