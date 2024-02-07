<?php

namespace App\Http\Controllers\Admin\Cms\NewsAndUpdates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Cms\NewsAndUpdates\NewsAndUpdatesService;

class NewsAndUpdatesController extends Controller
{
    protected $newsandupdates;

    public function __construct(NewsAndUpdatesService $newsandupdates)
    {
        $this->newsandupdates = $newsandupdates;
    }

    public function indexView()
    {
       return view('admin.cms.new-and-update.index');
    }

    public function index(Request $request)
    {
        return $this->newsandupdates->paginate(20, $request);
    }

    public function create()
    {
        return view('admin.cms.new-and-update.create');
    }

    public function store(Request $request)
    {
        if ($this->newsandupdates->store($request->all())) {
            return response(['status' => "OK"], 200);
    }
        return response(['status' => 'ERROR' ], 200);
    }

    public function show($id)
    {
        if ($newsandupdates = $this->newsandupdates->getById($id))
            return response(['status' => "OK" ,'newsandupdates' => $newsandupdates], 200);
        return response(['status' => 'ERROR'], 200);
    }

    public function edit($id)
    {
        return view('admin.cms.new-and-update.edit',compact('id'));
    }

    public function update(Request $request, $id)
    {
        $newsandupdates = $this->newsandupdates->update($id, $request->all());
        if ($newsandupdates)
            return response(['status' => "OK"], 200);

        return response(['status' => 'ERROR' ], 200);
    }

    public function destroy($id)
    {
        if ($this->newsandupdates->delete($id)) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);

    }
}
