<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;

class ManageSubscriptionController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Subscribers';

        $subscribers = Subscribe::latest()->paginate(20);

        return view('admin.subscriber.index',compact('pageTitle','subscribers'));
    }

    public function sendEmailToAll(Request $request)
    {
       $data= $request->validate(['subject' => 'required','message' => 'required']);

        $subscribers = Subscribe::latest()->get();

        foreach ($subscribers as $subscribe) {
            $data['email'] = $subscribe->email;
            $data['name'] = 'subscriber';
            
            sendGeneralMail($data);
        }

        $notify[] = ['success','Successfully send mail to all subscribers'];
        return back()->withNotify($notify);
    }

    public function sendEmailSubscriber(Request $request)
    {
        $data= $request->validate(['subject' => 'required','message' => 'required']);
        
        $subscribe = Subscribe::findOrFail($request->id);

        $data['email'] = $subscribe->email;
        $data['name'] = 'subscriber';

        sendGeneralMail($data);

        $notify[] = ['success','Send Mail To this Subscriber Successfully'];
        return back()->withNotify($notify);
    }


    public function deleteSubscriber(Request $request)
    {
        $subscribe = Subscribe::findOrFail($request->id);

        $subscribe->delete();

        $notify[] = ['success','Subscriber Deleted Successfully'];
        return back()->withNotify($notify);
    }
}
