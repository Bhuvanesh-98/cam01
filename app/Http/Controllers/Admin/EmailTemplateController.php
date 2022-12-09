<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function emailConfig()
    {
        $pageTitle = 'Email Configuration';

        return view('admin.email.config',compact('pageTitle'));
    }

    public function emailConfigUpdate(Request $request)
    {
        
        $data = $request->validate([
            'email_from' => 'required|email',
            'email_method' => 'required',
            'smtp_config' => "required_if:email_method,==,smtp",
            'smtp_config.*' => 'required_if:email_method,==,smtp'
        ]);

        $general = GeneralSetting::first();

        $general->update($data);

        $notify[] = ['success', "Email Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);

    }

    public function emailTemplates()
    {
        $pageTitle = 'Email Templates';

        $emailTemplates = EmailTemplate::latest()->paginate();

        return view('admin.email.templates',compact('pageTitle','emailTemplates'));
    }

    public function emailTemplatesEdit (EmailTemplate $template)
    {
        $pageTitle = 'Template Edit';
        
        return view('admin.email.edit',compact('pageTitle','template'));
    }

    public function emailTemplatesUpdate(Request $request, EmailTemplate $template)
    {
        $data = $request->validate([
            'subject' => 'required',
            'template' => 'required',
        ]);

        $template->update($data);


        $notify[] = ['success', "Email Template Updated Successfully"];

        return redirect()->back()->withNotify($notify);

    }
}
