<?php

namespace App\Http\Controllers\Admin\Cms\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\Team\TeamRequest;
use App\Http\Resources\Cms\Team\TeamResource;
use App\Services\Cms\Team\TeamService;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    protected $team;

    function __construct(TeamService $team)
    {
        $this->team = $team;
    }

    public function indexView()
    {
        return view('admin.cms.team.index');
    }

    public function index(Request $request)
    {
        return $this->team->paginate(20, $request);
    }

    public function sort(Request $request){
        if ($this->team->sort($request->all())) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);
    }

    public function store(TeamRequest $request)
    {
        if ($this->team->store($request->all())) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);

    }

    public function show($id)
    {
        if ($team = $this->team->find($id))
            return response(['status' => "OK" ,'team' => new TeamResource($team)], 200);
        return response(['status' => 'ERROR'], 200);
    }

    public function update(TeamRequest $request, $id)
    {
        $team = $this->team->update($id, $request->all());
        if ($team)
            return response(['status' => "OK"], 200);

        return response(['status' => 'ERROR' ], 200);
    }

    public function destroy($id)
    {
        if ($this->team->delete($id)) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);

    }
}
