<?php

namespace App\Http\Controllers\Admin\Cms\Album;

use App\Http\Controllers\Controller;
use App\Services\Cms\Album\AlbumService;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    protected $album;

    public function __construct(AlbumService $album)
    {
        $this->album = $album;
    }

    public function indexView()
    {
        return view('admin.cms.album.index');
    }

    public function index(Request $request)
    {
        return $this->album->paginate(25, $request);
    }

    public function activeAll()
    {
        $response = $this->album->findByColumns(['is_active' => 1], true);
        if ($response)
            return response($response, 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function store(Request $request)
    {
        $album = $this->album->store($request->all());
        if ($album)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function sort($id, $index)
    {
        $value = $this->album->sort($id, $index);
        if ($value)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function update(Request $request, $id)
    {
        $album = $this->album->update($id, $request->all());
        if ($album)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($id)
    {
        if ($this->album->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function show($id)
    {
        if ($album = $this->album->getById($id))
            return response(['status' => "OK", 'album' => $album], 200);
        return response(['status' => 'ERROR'], 500);
    }
}
