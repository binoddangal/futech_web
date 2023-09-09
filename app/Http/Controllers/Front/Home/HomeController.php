<?php

namespace App\Http\Controllers\Front\Home;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('front.pages.home.index');
    }

    public function contact()
    {
        return view('front.pages.contact.contactus');
    }

}
