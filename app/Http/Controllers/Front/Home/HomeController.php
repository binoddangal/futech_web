<?php

namespace App\Http\Controllers\Front\Home;

use App\Http\Controllers\Controller;
use App\Services\Cms\Blog\BlogService;
use App\Services\Cms\Blog\Category\BlogCategoryService;
use App\Services\Cms\OurProject\OurProjectService;

class HomeController extends Controller
{
    protected $ourProject;
    protected $category;
    protected $blog;

    public function __construct(

        OurProjectService $ourProject, BlogCategoryService  $category, BlogService $blog
    )
    {
        $this->ourProject = $ourProject;
        $this->category = $category;
        $this->blog = $blog;
    }

    public function index()
    {
        $ourProjects = $this->ourProject->getAllActive();
        $category = $this->category->getCategories(10);
        $blogs = $this->blog->getAllActive();
        return view('front.pages.home.index', compact('ourProjects', 'category', 'blogs'));
    }

    public function service()
    {
        $ourProjects = $this->ourProject->getAllActive();
        return view('front.pages.service.service', compact('ourProjects'));
    }

    public function blog()
    {
        $category = $this->category->getCategories(10);
        $blogs = $this->blog->getAllActive();
        return view('front.pages.blog.blog', compact('category', 'blogs'));
    }

    public function blogDetails()
    {
        return view('front.pages.blog.details');
    }

    public function about()
    {
        $ourProjects = $this->ourProject->getAllActive();
        return \view('front.pages.about.aboutus', compact('ourProjects'));
    }

    public function contact()
    {
        return view('front.pages.contact.contactus');
    }

}
