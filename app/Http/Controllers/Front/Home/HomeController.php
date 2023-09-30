<?php

namespace App\Http\Controllers\Front\Home;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('front.pages.home.index');
    }

    public function service()
    {
        return view('front.pages.service.service');
    }

    public function blog()
    {
        return view('front.pages.blog.blog');
    }

    public function blogDetails()
    {
        return view('front.pages.blog.details');
    }

    public function about()
    {
        return \view('front.pages.about.aboutus');
    }

    public function contact()
    {
        return view('front.pages.contact.contactus');
    }

}
