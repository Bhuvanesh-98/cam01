<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class ManageBookingController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'All Bookings';

        $bookings = Booking::when($request->search,function($q) use($request) {
            $q->where('trx','LIKE','%'.$request->search.'%');
        })->whereHas('service')->where('job_end','!=',1)->latest()->with('user','service')->paginate();

        return view('admin.bookings.index',compact('pageTitle','bookings'));
    }

    public function bookingComplete(Booking $booking)
    {
        $booking->is_completed = 1;
        $booking->save();

        sendMail('SERVICE_COMPLETE',['service' => $booking->service->name,'trx' => $booking->trx],$booking->user);
        sendMail('SERVICE_COMPLETE',['service' => $booking->service->name,'trx' => $booking->trx],$booking->service->user);

        $notify[] = ['success','Bookings Completed'];
        return redirect()->back()->withNotify($notify);
    }
    
    public function bookingDelete(Booking $booking)
    {
        $booking->delete();

        $notify[] = ['success','Bookings Completed'];
        return redirect()->back()->withNotify($notify);
    }

    public function completed (Request $request)
    {
        $pageTitle = 'Complete Bookings';

        $bookings = Booking::when($request->search,function($q) use($request) {
            $q->where('trx','LIKE','%'.$request->search.'%');
        })->whereHas('service')->where('is_completed',1)->latest()->with('user','service')->paginate();

        return view('admin.bookings.index',compact('pageTitle','bookings'));
    }
    
    public function inCompleted (Request $request)
    {
        $pageTitle = 'Incomplete Bookings';

        $bookings = Booking::when($request->search,function($q) use($request) {
            $q->where('trx','LIKE','%'.$request->search.'%');
        })->whereHas('service')->where('is_completed',0)->where('is_accepted','!=',2)->latest()->with('user','service')->paginate();

        return view('admin.bookings.index',compact('pageTitle','bookings'));
    }

    public function bookingEndContract(Booking $booking)
    {
        $booking->job_end = 1;

        $booking->save();

        sendMail('END_CONTRACT',['service' => $booking->service->name,'booking_id' => $booking->trx],$booking->service->user);
        sendMail('END_CONTRACT',['service' => $booking->service->name,'booking_id' => $booking->trx],$booking->user);

        $notify[] = ['success','Successfully end this job'];
       return redirect()->back()->withNotify($notify);

    }

    public function endJobs(Request $request)
    {
        $pageTitle = 'End Contracts';

        $bookings = Booking::when($request->search,function($q) use($request) {
            $q->where('trx','LIKE','%'.$request->search.'%');
        })->whereHas('service')->where('job_end',1)->latest()->with('user','service')->paginate();

        return view('admin.bookings.index',compact('pageTitle','bookings'));
    }
}
