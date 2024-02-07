<?php

namespace App\Http\Controllers\Admin\Cms\OurProject;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\OurProjectRequest\OurProjectRequest;
use App\Http\Resources\Cms\OurProject\OurProjectResource;
use App\Services\Cms\OurProject\OurProjectService;
use Illuminate\Http\Request;

class OurProjectController extends Controller

{
    protected $ourProject;

    function __construct(OurProjectService $ourProject)
    {
        $this->ourProject = $ourProject;
    }

    public function indexView()
    {
        return view('admin.cms.our-project.index');
    }

    public function index(Request $request)
    {
        return $this->ourProject->paginate(20, $request);
    }

    public function activeAll()
    {
        $response = $this->ourProject->findByColumns(['is_active' => 1], true);
        if ($response)
            return response($response, 200);
        return response(['status' => 'ERROR'], 500);
    }
    public function store(OurProjectRequest $request)
    {
        if ($this->ourProject->store($request->all())) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);

    }

    public function show($id)
    {
        if ($ourProject = $this->ourProject->find($id))
            return response(['status' => "OK" ,'team' => new OurProjectResource($ourProject)], 200);
        return response(['status' => 'ERROR'], 200);
    }

    public function update(OurProjectRequest $request, $id)
    {
        $ourProject = $this->ourProject->update($id, $request->all());
        if ($ourProject)
            return response(['status' => "OK"], 200);

        return response(['status' => 'ERROR' ], 200);
    }

    public function destroy($id)
    {
        if ($this->ourProject->delete($id)) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);

    }
}
