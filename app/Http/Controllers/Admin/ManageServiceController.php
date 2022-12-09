<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;

class ManageServiceController extends Controller
{
    public function index(Request $request)
    {
       $pageTitle = "All services";

       $services = Service::whereHas('user')->when($request->search, function($q) use($request){
           $q->where('name','LIKE','%'.$request->search.'%');
       })->latest()->with('category','user','reviews')->paginate();

       return view('admin.service.index',compact('pageTitle','services'));
    }

    public function reviewMessage(Service $service)
    {
        $pageTitle = 'Review Messages';

        $reviews = $service->reviews()->with('user','service')->latest()->paginate();

        return view('admin.service.message',compact('pageTitle','reviews'));
    }

    public function reviewMessageUpdate(Request $request , Review $service)
    {
        $request->validate(['status'=> 'required|in:0,1']);

        $service->status = $request->status;
        $service->save();

        $notify[] = ['success','Successfully Update Review'];
        return back()->withNotify($notify);
    }

    public function acceptService(Service $service)
    {
        $service->admin_approval = 1;

        $service->status = 1;

        $service->save();

        sendMail('SERVICE_APPROVAL',['service' => $service->name],$service->user);

        $notify[] = ['success','Successfully Accepted Service'];
        return back()->withNotify($notify);
    }
    public function rejectService(Request $request, Service $service)
    {
        $request->validate(['reason_of_reject'=>'required']);
        
        $service->admin_approval = 2;
        $service->reason_of_reject = $request->reason_of_reject;

        $service->save();

        sendMail('SERVICE_REJECTED',['reason'=> $request->reason_of_reject,'service' => $service->name],$service->user);

        $notify[] = ['success','Successfully rejected Service'];
        return back()->withNotify($notify);
    }
}
