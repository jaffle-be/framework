<?php namespace App\Contact\Http;

use App\Http\Controllers\Controller;

class ContactController extends Controller{

    public function index()
    {
        return view('contact::contact-advanced');
    }

}