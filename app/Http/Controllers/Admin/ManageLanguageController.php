<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;


class ManageLanguageController extends Controller
{
    public function navbarText()
    {
        $pageTitle = 'Navbar Text';

        $language = json_decode(file_get_contents(resource_path('lang/navbar.json')),true);

        return view('admin.language.index',compact('pageTitle','language'));
    }

    public function navbarTextUpdate(Request $request)
    {
        $data = json_encode($request->lang);

        file_put_contents(resource_path('lang/navbar.json'),$data);

        $notify[] = ['success','Update Success'];
        return redirect()->back()->withNotify($notify);
    }

    public function websiteText()
    {
        $pageTitle = 'Website Text';

        $language = json_decode(file_get_contents(resource_path('lang/website.json')),true);

        return view('admin.language.index',compact('pageTitle','language'));
    }

    public function websiteTextUpdate (Request $request)
    {
        $data = json_encode($request->lang);

        file_put_contents(resource_path('lang/website.json'),$data);

        $notify[] = ['success','Update Success'];
        return redirect()->back()->withNotify($notify);
    } 
    
    public function validationText()
    {
        $pageTitle = 'Notification Text';

        $language = json_decode(file_get_contents(resource_path('lang/validation.json')),true);

        return view('admin.language.index',compact('pageTitle','language'));
    }

    public function validationTextUpdate (Request $request)
    {
        $data = json_encode($request->lang);

        file_put_contents(resource_path('lang/validation.json'),$data);

        $notify[] = ['success','Update Success'];
        return redirect()->back()->withNotify($notify);
    }
}
