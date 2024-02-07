<?php

namespace App\Http\Controllers\Admin\Cms\Career;

use App\Http\Controllers\Controller;
use App\Services\Cms\Career\CareerService;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    protected $career;


    public function __construct(CareerService $careerService)
    {
        $this->career = $careerService;
    }
    public function indexView()
    {
        return view('admin.cms.career.index');
    }


    public function edit($id)
    {
        return view('admin.cms.career.edit',compact('id'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->career->paginate($request->all(),25);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cms.career.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $career = $this->career->store($request->all());
        if ($career)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($career = $this->career->getById($id))
            return response(['status' => "OK", 'career' => $career], 200);
        return response(['status' => 'ERROR'], 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $career = $this->career->update($id, $request->all());
        if ($career)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->career->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }
}
