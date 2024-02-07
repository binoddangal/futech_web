<?php

namespace App\Http\Controllers\Admin\Cms\Download\Type;

use App\Http\Controllers\Controller;
use App\Services\Cms\Download\Type\DownloadTypeService;
use Illuminate\Http\Request;

class DownloadTypeController extends Controller
{
    protected $type;

    public function __construct(DownloadTypeService $type)
    {
        $this->type = $type;
    }

    public function indexView()
    {
        return view('admin.cms.download.type.index');
    }

    public function index()
    {
        return response($this->type->paginate(25));
    }

    public function store(Request $request)
    {
        $type = $this->type->store($request->all());
        if ($type)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function update(Request $request, $id)
    {
        $type = $this->type->update($id, $request->all());
        if ($type)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($id)
    {
        if ($this->type->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }


    public function show($id)
    {
        if ($type = $this->type->getById($id))
            return response(['status' => "OK", 'type' => $type], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function getActive(){
        return response($this->type->getActive());
    }
}
