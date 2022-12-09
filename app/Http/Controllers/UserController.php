<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\Review;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\WithdrawLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Nette\Utils\Random;
use Purifier;

class UserController extends Controller
{
    public function dashboard()
    {
        $pageTitle = 'DashBoard';

        $user = auth()->user();

        if ($user->user_type == 2) {
            $balance = $user->balance;
            $service = $user->services->count();

            $jobCompleted = Booking::where('is_completed', 1)->whereHas('service', function ($q) {
                $q->where('user_id', auth()->id());
            })->count();

            $serve = Service::where('user_id', $user->id)->pluck('id')->toArray();
            
            $myRatings = Review::whereIn('service_id',$serve)->avg('review');
            

            $services = Service::where('user_id', $user->id)->paginate(10);


            $bookings = Booking::whereHas('service',function($q){$q->where('user_id',auth()->id());})->latest()->with('user', 'service')->paginate(10);

            return view('frontend.user.dashboard', compact('pageTitle', 'balance', 'service', 'jobCompleted', 'services','myRatings','bookings'));
        }

        $booking = Booking::where('user_id', $user->id)->count();
        $bookingPending = Booking::where('user_id', $user->id)->where('is_accepted', 0)->count();
        $bookingComplete = Booking::where('user_id', $user->id)->where('is_completed', 1)->count();
        $totalTransactionAmount = Transaction::where('user_id', $user->id)->sum('amount');
        $totalTransactionCharge = Transaction::where('user_id', $user->id)->sum('charge');

        $totalTransaction = $totalTransactionAmount + $totalTransactionCharge;

        $bookings = Booking::whereHas('service')->where('user_id', $user->id)->latest()->paginate();


        return view('frontend.user.dashboard', compact('pageTitle', 'booking', 'bookingPending', 'bookingComplete', 'totalTransaction', 'bookings'));
    }

    public function profile()
    {
        $pageTitle = 'Profile Setting';

        $user = auth()->user();

        return view('frontend.user.profile', compact('pageTitle', 'user'));
    }

    public function profileUpdate(Request $request)
    {

        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'mobile' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'address' => 'required',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg',
            'designation' => 'sometimes|required',
            'details' => 'sometimes|required|',
            'experience' => 'sometimes|required',
            'qualification' => 'sometimes|required',
            'social' => 'sometimes|array'
        ], [
            'fname.required' => 'First Name is required',
            'lname.required' => 'Last Name is required',

        ]);

        $user = auth()->user();

        if ($request->hasFile('image')) {
            $filename = uploadImage($request->image, filePath('user'), $user->image);
            $user->image = $filename;
        }

        $address = [
            'country' => $request->country,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'address' => $request->address
        ];

        if ($user->user_type == 2) {
            $user->designation = $request->designation;
            $user->details =  Purifier::clean($request->details);
            $user->experience =  Purifier::clean($request->experience);
            $user->qualification =  Purifier::clean($request->qualification);
            $user->social = $request->social;
        }

        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->mobile = $request->mobile;
        $user->address = $address;

        $user->save();


        $notify[] = ['success', 'Successfully Updated Profile'];

        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = "Change Password";

        return view('frontend.user.change_password', compact('pageTitle'));
    }

    public function changePasswordUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $user = auth()->user();

       
        $user->password = bcrypt($request->password);
        $user->save();


        $notify[] = ['success', 'Password changed Successfully'];

        return back()->withNotify($notify);
    }

    public function transaction()
    {
        $pageTitle = "Transactions";

        $transactions = Transaction::where('user_id', auth()->id())->latest()->with('user')->paginate();

        return view('frontend.user.transaction', compact('pageTitle', 'transactions'));
    }

    public function withdraw()
    {
        $pageTitle = 'Withdraw Money';

        $withdraws = Withdraw::where('status',1)->latest()->get();

        return view('frontend.user.provider.withdraw', compact('pageTitle', 'withdraws'));
    }

    public function withdrawCompleted(Request $request)
    {
        
        $request->validate([
            'method' => 'required|integer',
            'amount' => 'required|numeric',
            'final_amo' => 'required|numeric',
            'email' => 'required|email'
        ]);

        $withdraw = Withdraw::findOrFail($request->method);

        if(auth()->user()->balance < $request->final_amo){
            $notify[] = ['error', 'Insuficient Balance'];

            return back()->withNotify($notify);
        }

        if($request->final_amo < $withdraw->min_withdraw || $request->final_amo > $withdraw->max_withdraw){
            $notify[] = ['error', 'Please follow the withdraw limits'];

            return back()->withNotify($notify);
        }

        if($withdraw->charge_type == 'percent'){

            $total = $request->amount + ($withdraw->charge * $request->amount) / 100;
        }else{
            $total = $request->amount + $withdraw->charge;
        }

        if($total != $request->final_amo){
            $notify[] = ['error', 'Invalid Amount'];

            return back()->withNotify($notify);
        }
        
        

        auth()->user()->balance = auth()->user()->balance - $total;
        auth()->user()->save();


        $data = [
            'email' => $request->email,
            'account_information' => Purifier::clean($request->account_information),
            'note' => Purifier::clean($request->note)
        ];


        $mailData = WithdrawLog::create([
            'user_id' => auth()->id(),
            'withdraw_gateway_id' => $request->method,
            'trx' => strtoupper(Random::generate(15)),
            'user_data' => $data,
            'charge' => $withdraw->charge,
            'amount' => $total,
            'balance_remains' => auth()->user()->balance,
            'status' => 0
        ]);

        $admin = Admin::first();

        sendMail('WITHDRAW_BALANCE',['trx'=>$mailData->trx,'amount'=>$mailData->amount,'user'=>auth()->user()->fullname,'method' => $withdraw->name ], $admin);


        $notify[] = ['success', 'Withdraw Successfully done'];

        return back()->withNotify($notify);
    }

    public function withdrawFetch(Request $request)
    {
        $withdraw = Withdraw::findOrFail($request->id);

        return $withdraw;
    }

    public function allWithdraw()
    {
        $pageTitle = 'All withdraw';

        $withdrawlogs = WithdrawLog::where('user_id', auth()->id())->latest()->with('withdraw')->paginate(10);

        return view('frontend.user.provider.withdraw_all',compact('pageTitle','withdrawlogs'));
    }

    public function pendingWithdraw()
    {
        $pageTitle = 'Pending withdraw';

        $withdrawlogs = WithdrawLog::where('user_id', auth()->id())->where('status',0)->latest()->with('withdraw')->paginate(10);

        return view('frontend.user.provider.withdraw_pending',compact('pageTitle','withdrawlogs'));
    }

    public function chat(Request $request)
    {

        $booking = Booking::where('trx', $request->transaction)->first();

        if($booking->job_end == 1){
            $notify[] = ['error', 'Job Expired'];

            return back()->withNotify($notify);
        }

        $pageTitle = "Chat with {$booking->user->fullname}";

        $chats  = Chat::where('provider_id',auth()->id())->where('user_id', $booking->user->id)->where('booking_id', $booking->id)->get();

        return view('frontend.user.provider.chat',compact('pageTitle','booking','chats'));
    }

    public function chatSend(Request $request)
    {
        $booking = Booking::where('trx', $request->transaction)->first();

        $request->validate([
            'message' => 'required',
            'user' => 'required',
            'provider' => 'required'
        ]);

        Chat::create([
            'message' => $request->message,
            'user_id' => $request->user,
            'booking_id' => $booking->id,
            'provider_id' => $request->provider,
            'sender' => 'provider'
        ]);

        sendMail("SEND_MESSAGE",['user'=>$booking->service->user->fullname,'message' => $request->message], $booking->user);


        $notify[] = ['success', 'Message Send Successfully'];

        return back()->withNotify($notify);

    }


    public function chatProvider(Request $request)
    {
       
        $booking = Booking::where('trx', $request->transaction)->first();

        if($booking->job_end == 1){
            $notify[] = ['error', 'Job Expired'];

            return back()->withNotify($notify);
        }

        $pageTitle = "Chat with {$booking->service->user->fullname}";

        $chats  = Chat::where('provider_id',$booking->service->user->id)->where('user_id', auth()->id())->where('booking_id', $booking->id)->get();

    
        return view('frontend.user.chat_user',compact('pageTitle','booking','chats'));
    }

    public function chatSendProvider (Request $request)
    {
        $booking = Booking::where('trx', $request->transaction)->first();

        $request->validate([
            'message' => 'required',
            'user' => 'required',
            'provider' => 'required'
        ]);

        Chat::create([
            'message' => $request->message,
            'user_id' => $request->user,
            'provider_id' => $request->provider,
            'sender' => 'user',
            'booking_id' => $booking->id,
        ]);

        sendMail("SEND_MESSAGE",['user'=>$booking->user->fullname,'message' => $request->message], $booking->service->user);


        $notify[] = ['success', 'Message Send Successfully'];

        return back()->withNotify($notify);
    }
}
