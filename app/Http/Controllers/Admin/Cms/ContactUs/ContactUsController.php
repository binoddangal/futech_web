<?php

namespace App\Http\Controllers\Admin\Cms\ContactUs;

use App\Http\Controllers\Controller;
use App\Services\Cms\ContactUs\ContactUsService;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    protected $contact;

    public function __construct(ContactUsService $contact)
    {
        $this->contact = $contact;
    }

    public function indexView()
    {
        return view('admin.cms.contact.index');
    }

    public function index(Request $request)
    {
        return $this->contact->paginate($request->all(), 25);
    }

    public function store(Request $request)
    {
        $contact = $this->contact->store($request->all());
        if ($contact)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function update(Request $request, $id)
    {
        $contact = $this->contact->update($id, $request->all());
        if ($contact)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($enrollmentUserId, $id)
    {
        if ($this->contact->delete($enrollmentUserId, $id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }


    public function show($id)
    {
        if ($contact = $this->contact->getById($id))
            return response(['status' => "OK", 'contact' => $contact], 200);
        return response(['status' => 'ERROR'], 500);
    }

    // public function exportList(Request $request)
    // {
    //     if (!empty(auth()->guard('web')->user())) {
    //         ob_end_clean();
    //         ob_start();
    //         return App\Http\Controllers\User\ContactUs\Excel::download(new DownloadEnqueryExport($request->all()), 'ResourseDownloadedList.xlsx');
    //     }
    // }
}
