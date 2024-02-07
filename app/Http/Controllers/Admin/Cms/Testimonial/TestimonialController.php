<?php

namespace App\Http\Controllers\Admin\Cms\Testimonial;

use App\Http\Controllers\Controller;
use App\Services\Cms\Testimonial\TestimonialService;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public $testimonial;

    public function __construct(TestimonialService $testimonial)
    {
        $this->testimonial = $testimonial;
    }

    public function indexView()
    {
        return view('admin.cms.testimonial.index');
    }

    public function index(Request $request)
    {
        return $this->testimonial->paginate(20, $request);
    }

    public function create()
    {
        return view('admin.cms.testimonial.create');
    }

    public function store(Request $request)
    {
        $testimonial = $this->testimonial->store($request->all());
        if ($testimonial)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function sort(Request $request)
    {
        $testimonial = $this->testimonial->sort( $request->all());
        if ($testimonial)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function edit($id)
    {
        return view('admin.cms.testimonial.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $testimonial = $this->testimonial->update($id, $request->all());
        if ($testimonial)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($id)
    {
        if ($this->testimonial->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function show($id)
    {
        if ($testimonial = $this->testimonial->getById($id))
            return response(['status' => "OK", 'testimonial' => $testimonial], 200);
        return response(['status' => 'ERROR'], 500);
    }
}
