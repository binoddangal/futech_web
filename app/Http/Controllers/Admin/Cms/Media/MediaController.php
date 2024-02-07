<?php

namespace App\Http\Controllers\Admin\Cms\Media;

use App\Http\Controllers\Controller;
use App\Services\Cms\Media\MediaService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public $media;

    public function __construct(MediaService $media)
    {
        $this->media = $media;
    }

    public function indexView()
    {
        return view('admin.cms.media.index');
    }

    public function index(Request $request)
    {
        return $this->media->paginate($request->all(), 14);
    }

    public function store(Request $request)
    {
        $media = $this->media->store($request->all(), auth()->guard('admin')->user()->id);
        if ($media)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function update(Request $request, $id)
    {
        $media = $this->media->update($id, $request->all());
        if ($media)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($id)
    {
        if ($this->media->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }


    public function show($id)
    {
        if ($media = $this->media->getById($id))
            return response(['status' => "OK", 'media' => $media], 200);
        return response(['status' => 'ERROR'], 500);
    }
}
