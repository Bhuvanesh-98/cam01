<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Nette\Utils\Random;
use Purifier;

class BookingController extends Controller
{
    public function booking(Request $request, Service $service)
    {
        if (isset($request['end_date'])) {
            $request->validate([
                'date' => 'required|after_or_equal:today',
                'end_date' => 'required|after_or_equal:today',
                'time' => 'required',
                'location' => 'required',
                'message' => 'required',
                'hours' => 'sometimes'
            ]);
        } else {
            $request->validate([
                'date' => 'required|after_or_equal:today',
                'time' => 'required',
                'location' => 'required',
                'message' => 'required',
                'hours' => 'sometimes'
            ]);
        }

        $weekname = Carbon::parse($request->date)->format('l');

        $schedules = $service->user->schedules()->where('week_name', $weekname)->get();

        if ($schedules->isEmpty()) {

            $notify[] = ['error', 'No Schedules Found for This Date'];

            return redirect()->back()->withNotify($notify);
        }

        $trx = strtoupper(Random::generate(15));

        $serviceDate = Carbon::parse($request->date);

        $startTime = Carbon::parse($request->time)->format('h:i a');


        foreach ($schedules as $schedule) {
            $scheduleStartTime = strtotime(Carbon::parse($schedule->start_time)->format('h:i a'));

            $scheduleEndTime = strtotime(Carbon::parse($schedule->end_time)->format('h:i a'));

            if(in_array(strtotime($startTime), range($scheduleStartTime, $scheduleEndTime))){
                $isNotAvailable = false;
                
                break;
            }else{
                $isNotAvailable = true;
            }
        }

        if(isset($isNotAvailable) && $isNotAvailable){
            $notify[] = ['error', 'No Schedules Found for This time'];

            return redirect()->back()->withNotify($notify);
        }

        $bookings = Booking::where('user_id', auth()->id())->where('service_id' , $service->id)->where('is_accepted','!=',2)->where('is_completed', 0)->first();

        if($bookings){
            $notify[] = ['error', 'Already Booked This service'];

            return redirect()->back()->withNotify($notify);
        }

        
        switch ($service->duration) {
            case $service::HOURLY:
                $endTime = Carbon::parse($request->time)->addHours($request->hours)->format('h:i');
                $endDate = $serviceDate->addHours($request->hours);
                $amount = $service->rate * $request->hours;
                break;

            case $service::DAILY:
                $endDate = isset($request['end_date']) ? Carbon::parse($request['end_date']) : $serviceDate->addDay(0);
                $end_date = Carbon::parse($endDate);
                $diff = $end_date->diffInDays($serviceDate) + 1;
                $amount = $service->rate * $diff;
                break;

            case $service::WEEKLY:
                $endDate = $serviceDate->addDays(7);
                break;
            case $service::MONTHLY:
                $endDate = $serviceDate->addDays(30);
                break;
            case $service::YEARLY:
                $endDate = $serviceDate->addYear();
                break;

            default:
                $endTime = Carbon::parse($request->time)->addHours($request->hours)->format('h:i');
                break;
        }

        $booking = Booking::create([
            'trx' => $trx,
            'user_id' => auth()->id(),
            'service_id' => $service->id,
            'service_date' =>  $serviceDate,
            'hours' => $request->hours ?? 0,
            'end_date' => $endDate ?? null,
            'start_time' =>  Carbon::parse($request->time)->format('h:i'),
            'end_time' => $endTime ?? null,
            'amount' => $amount ?? $service->rate,
            'message' => Purifier::clean($request->message),
            'location' => $request->location
        ]);

        sendMail('BOOKING_SERVICE',['trx'=>$booking->trx,'user' => $booking->user->fullname,'service' => $booking->service->name],$booking->user);


        session()->put('trx', $trx);

        $notify[] = ['success', 'Successfully Booked A service. Wait for Service Provider Confirmation'];

        return redirect()->back()->withNotify($notify);
    }

    public function allBookings(Request $request)
    {
        $pageTitle = 'All Bookings';

        $bookings = Booking::when($request->search, function($q) use($request){
            $q->where('trx','LIKE','%'.$request->search.'%');
        })->whereHas('service')->where('user_id', auth()->id())->latest()->with('user', 'service')->paginate();

        return view('frontend.user.bookings', compact('pageTitle', 'bookings'));
    }

    public function serviceBooking(Request $request)
    {
        $pageTitle = 'All Bookings';

        $bookings = Booking::when($request->search, function($q) use($request){
            $q->where('trx','LIKE','%'.$request->search.'%');
        })->whereHas('service',function($q){$q->where('user_id',auth()->id());})->latest()->with('user', 'service')->paginate();

        return view('frontend.user.provider.booked_service', compact('pageTitle', 'bookings'));
    }

    public function serviceBookingAccept(Booking $booking)
    {
        $booking->is_accepted = 1;

        $booking->save();

        sendMail('BOOKING_ACCEPTED',['trx'=>$booking->trx,'user' => $booking->service->user->fullname, 'service' => $booking->service->name],$booking->user);

        $notify[] = ['success', 'Successfully accepted Booking'];

        return redirect()->back()->withNotify($notify);
    }

    public function serviceBookingReject (Booking $booking)
    {
       
        $booking->is_accepted = 2;

        $booking->save();

        sendMail('BOOKING_REJECTED',['user'=>$booking->service->user->fullname,'service' => $booking->service->name,'booking_id' => $booking->trx],$booking->user);

        $notify[] = ['success', 'Successfully rejected Booking'];

        return redirect()->back()->withNotify($notify);
    }

    public function bookingCompleted(Request $request)
    {
       $booking = Booking::findOrFail($request->id);

       $booking->is_completed = 1;
       $booking->save();

       sendMail('SERVICE_COMPLETE',['service' => $booking->service->name,'trx' => $booking->trx],$booking->service->user);

       $notify[] = ['success','Bookings Completed'];
        return redirect()->back()->withNotify($notify);
    }

    public function endContract(Booking $booking)
    {
        $admin = Admin::first();
       $booking->job_end = 2;
       $booking->save();
    
       sendMail('JOB_CONTRACT_END_REQUEST',['service' => $booking->service->name,'booking_id' => $booking->trx,'provider'=>$booking->service->user->fullname],$admin);

       $notify[] = ['success','Successfully Requested to admin'];
       return redirect()->back()->withNotify($notify);
    }
   
}
