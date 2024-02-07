<?php

namespace App\Http\Controllers\Admin\Cms\Partner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\Partner\PartnerRequest;
use App\Http\Resources\Cms\Partner\PartnerResource;
use App\Services\Cms\Partner\PartnerService;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    protected $partner;

    public function __construct(PartnerService $partner) {
        $this->partner = $partner;
    }

    public function indexView()
    {
        return view('admin.cms.partner.index');
    }

    public function index(Request $request)
    {
        return $this->partner->paginate(20, $request);
    }

    public function store(PartnerRequest $request)
    {
        if ($this->partner->store($request->all())) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);
    }

    public function show($id)
    {
        if ($partner = $this->partner->find($id))
            return response(['status' => "OK" ,'partner' => new PartnerResource($partner)], 200);
        return response(['status' => 'ERROR'], 200);
    }

    public function update(PartnerRequest $request, $id)
    {
        $partner = $this->partner->update($id, $request->all());
        if ($partner)
            return response(['status' => "OK"], 200);

        return response(['status' => 'ERROR' ], 200);
    }

    public function destroy($id)
    {
        if ($this->partner->delete($id)) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);

    }
}
