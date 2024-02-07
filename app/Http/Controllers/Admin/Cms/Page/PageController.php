<?php

namespace App\Http\Controllers\Admin\Cms\Page;

use App\Http\Controllers\Controller;
use App\Services\Cms\Page\PageService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public $page;

    public function __construct(PageService $page)
    {
        $this->page = $page;
    }

    public function indexView()
    {
        return view('admin.cms.page.index');
    }

    public function index(Request $request)
    {
        return $this->page->paginate($request->all(), 25);
    }

    public function store(Request $request)
    {
        $page = $this->page->store($request->all());
        if ($page)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function update(Request $request, $id)
    {
        $page = $this->page->update($id, $request->all());
        if ($page)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($id)
    {
        if ($this->page->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }


    public function show($id)
    {
        if ($page = $this->page->getById($id))
            return response(['status' => "OK", 'page' => $page], 200);
        return response(['status' => 'ERROR'], 500);
    }
}
