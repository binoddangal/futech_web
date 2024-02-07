<?php

namespace App\Http\Controllers\Admin\EmailTemplate;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailTemplate\EmailTemplateRequest;
use App\Services\EmailTemplate\EmailTemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class EmailTemplateController extends Controller
{
    public $emailTemplate;

    public function __construct(EmailTemplateService $emailTemplate)
    {
        $this->emailTemplate = $emailTemplate;
    }

    public function indexView($role)
    {
        return view("admin.email-template.index", compact('role'));
    }

    public function roleView()
    {
        return view("admin.email-template.role");
    }

    public function edit($id)
    {
        return view("admin.email-template.edit", compact('id'));
    }

    public function emailTemplateRoles()
    {
        $roles = [];
        $emailTemplates = Config::get('email-template');
        if (sizeof($emailTemplates) > 0) {
            foreach ($emailTemplates['roles'] as $key => $template) {
                array_push($roles, [ucwords(str_replace('_', ' ', $key)), $key]);
            }
        }
        return $roles;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        return $this->emailTemplate->paginate(25, $request, $user);
    }

    public function store(EmailTemplateRequest $request)
    {
        $emailTemplate = $this->emailTemplate->store($request->all());
        if ($emailTemplate)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function update(EmailTemplateRequest $request, $id)
    {
        $emailTemplate = $this->emailTemplate->update($id, $request->all());
        if ($emailTemplate)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($id)
    {
        if ($this->emailTemplate->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }


    public function show($id)
    {
        if ($emailTemplate = $this->emailTemplate->getById($id))
            return response(['status' => "OK" ,'email_template' => $emailTemplate], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function getLevelByDetail($emailTemplate)
    {
        $emailTemplate = $this->emailTemplate->findByColumn('email_template', $emailTemplate);
        if ($emailTemplate)
            return response(['status' => "OK" ,'emailTemplate' => $emailTemplate], 200);
        return response(['status' => 'ERROR'], 500);
    }
    public function cloneEmailTemplate(Request $request)
    {
        $emailTemplate=$this->emailTemplate->cloneEmailTemplate($request->all());
        if($emailTemplate)
            return response(['status' => $emailTemplate], 200);
        return response(['status' => $emailTemplate], 500);
    }
}
