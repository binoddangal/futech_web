<?php

namespace App\Http\Controllers\Admin\Cms\Career\Application;

use App\Http\Controllers\Controller;
use App\Services\Cms\Career\Application\CareerApplicationService;
use Illuminate\Http\Request;


class CareerApplicationController extends Controller
{
    protected $application;

    public function __construct(CareerApplicationService $application)
    {
        $this->application = $application;
    }
    public function indexView($id)
    {
        return view('admin.cms.career.application.index',compact('id'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->application->paginate(25,$request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {

      $application = $this->application->all();
      return response(['applications'=> applications]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'received_at' => \Carbon\Carbon::now(),
            'is_read' => 0
        ]);
        $application = $this->application->store($request->slug, $request->all());
        if ($application)
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
        if ($application = $this->application->getById($id))
            return response(['status' => "OK", 'application' => $application], 200);
        return response(['status' => 'ERROR'], 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $application = $this->application->update($id, $request->all());
        if ($application)
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
        if ($this->application->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }
}
