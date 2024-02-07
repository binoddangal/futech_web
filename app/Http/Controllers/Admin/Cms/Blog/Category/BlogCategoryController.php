<?php

namespace App\Http\Controllers\Admin\Cms\Blog\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\Blog\Category\BlogCategoryRequest;
use App\Http\Resources\Cms\Blog\Category\BlogCategoryResource;
use App\Services\Cms\Blog\Category\BlogCategoryService;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{

    protected $category;

    public function __construct(BlogCategoryService $category)
    {
        $this->category = $category;
    }

    public function indexView()
    {
        return view('admin.cms.blog.category.index');
    }

    public function index(Request $request)
    {
        return $this->category->paginate(25, $request);
    }

    public function parent()
    {
        return $this->category->getParent();
    }


    public function store(BlogCategoryRequest $request)
    {
        if ($this->category->store($request->all())) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);
    }

    public function show($id)
    {
        if ($category = $this->category->find($id))
            return response(['status' => "OK" ,'category' => new BlogCategoryResource($category)], 200);
        return response(['status' => 'ERROR'], 200);
    }

    public function update(BlogCategoryRequest $request, $id)
    {
        $category = $this->category->update($id, $request->all());
        if ($category)
            return response(['status' => "OK"], 200);

        return response(['status' => 'ERROR' ], 200);
    }

    public function destroy($id)
    {
        if ($this->category->delete($id)) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);

    }
}
