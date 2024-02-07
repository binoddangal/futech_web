<?php

namespace App\Http\Controllers\Admin\Cms\Album\Value;

use App\Http\Controllers\Controller;
use App\Services\Cms\Album\Value\AlbumValueService;
use Illuminate\Http\Request;

class AlbumValueController extends Controller
{
    public $value;

    public function __construct(AlbumValueService $value)
    {
        $this->value = $value;
    }

    public function indexView($id)
    {
        return view('admin.cms.album.value.index', compact('id'));
    }

    public function index($albumId)
    {
        return response($this->value->paginate($albumId, 25));
    }

    public function store($albumId, Request $request)
    {
        $value = $this->value->store($albumId, $request->all());
        if ($value)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function sort($albumId, Request $request)
    {
        $value = $this->value->sort($albumId, $request->all());
        if ($value)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function update($albumId, Request $request, $id)
    {
        $value = $this->value->update($albumId, $id, $request->all());
        if ($value)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($albumId, $id)
    {
        if ($this->value->delete($albumId, $id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function show($albumId, $id)
    {
        if ($value = $this->value->getById($albumId, $id))
            return response(['status' => "OK", 'value' => $value], 200);
        return response(['status' => 'ERROR'], 500);
    }
}
