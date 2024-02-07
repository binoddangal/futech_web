<?php

namespace App\Http\Controllers\Admin\Cms\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cms\Blog\BlogRequest;
use App\Services\Cms\Blog\BlogService;

class BlogController extends Controller
{
    protected $blog;

    public function __construct(BlogService $blog)
    {
        $this->blog = $blog;
    }

    public function indexView()
    {
       return view('admin.cms.blog.index');
    }

    public function indexNewAndUpdate()
    {
       return view('admin.cms.new-and-update.index');
    }

    public function index(Request $request)
    {
        return $this->blog->paginate(20, $request);
    }

    public function create()
    {
        return view('admin.cms.blog.create');
    }

    public function createNewAndUpdate()
    {
        return view('admin.cms.new-and-update.create');
    }

    public function store(Request $request)
    {
        if ($this->blog->store($request->all())) {
            return response(['status' => "OK"], 200);
    }
        return response(['status' => 'ERROR' ], 200);
    }

    public function show($id)
    {
        if ($blog = $this->blog->getById($id))
            return response(['status' => "OK" ,'blog' => $blog], 200);
        return response(['status' => 'ERROR'], 200);
    }

    public function edit($id)
    {
        return view('admin.cms.blog.edit',compact('id'));
    }

    public function editNewAndUpdate($id)
    {
        return view('admin.cms.new-and-update.edit',compact('id'));
    }

    public function update(BlogRequest $request, $id)
    {
        $blog = $this->blog->update($id, $request->all());
        if ($blog)
            return response(['status' => "OK"], 200);

        return response(['status' => 'ERROR' ], 200);
    }

    public function destroy($id)
    {
        if ($this->blog->delete($id)) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);

    }
}
