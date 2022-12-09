<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Gateway;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManageGatewayController extends Controller
{
    public function bank()
    {
        $pageTitle = 'Bank Payment';

        $gateway = Gateway::where('gateway_name', 'bank')->first();

        return view('admin.gateways.bank',compact('pageTitle','gateway'));
    } 

    public function bankUpdate(Request $request)
    {
    
        $gateway = Gateway::where('gateway_name', 'bank')->first();

        $request->validate([
            "name" => 'required',
            "account_number" => 'required',
            "routing_number" => 'required',
            "branch_name" => 'required',
            "user_proof_param" => 'sometimes|array',
            'bank_image' => [Rule::requiredIf(function()use ($gateway){return $gateway == null;}),'image','mimes:jpg,png,jpeg'],
            'status' => 'required',
            'rate'=> 'required',
            'charge' => 'required',
            'gateway_currency' => 'required'
        ]);

        

        $gatewayParameters= [
            'name' => $request->name,
            'account_number' => $request->account_number,
            'routing_number' => $request->routing_number,
            'branch_name' => $request->branch_name,
            'gateway_currency' => $request->gateway_currency
        ];


       if($gateway){
        if($request->hasFile('bank_image')){
            $filename = uploadImage($request->bank_image,filePath('gateways'), $gateway->gateway_image );
        }

       
        $gateway->update([
            'gateway_image' => $filename ?? $gateway->gateway_image,
            'gateway_parameters' => $gatewayParameters,
            'user_proof_param' => $request->user_proof_param,
            'status' => $request->status,
            'rate' => $request->rate,
            'charge' => $request->charge
        ]);


        
        $notify[] = ['success', "Bank Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);

       }


       if($request->hasFile('bank_image')){
            $filename = uploadImage($request->bank_image,filePath('gateways'));
        }

        
        Gateway::create([
            'gateway_name' => 'bank',
            'gateway_image' => $filename,
            'gateway_parameters' => $gatewayParameters,
            'user_proof_param' => $request->user_proof_param,
            'gateway_type' => 0,
            'status' => $request->status,
            'rate' => $request->rate,
            'charge' => $request->charge
        ]);


        $notify[] = ['success', "Bank Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);






    }
    
    public function paypal()
    {
        $pageTitle = 'Paypal Payment';

        $gateway = Gateway::where('gateway_name', 'paypal')->first();

        return view('admin.gateways.paypal',compact('pageTitle','gateway'));
    } 


    public function paypalUpdate(Request $request)
    {
       $gateway = Gateway::where('gateway_name', 'paypal')->first();

       $request->validate([
           'gateway_currency' => 'required',
           'paypal_client_id' => 'required',
           'paypal_client_secret' => 'required',
           'paypal_image' => [Rule::requiredIf(function() use($gateway){ return $gateway == null ;})],
           'status' => 'required',
           'mode' => 'required',
           'rate'=> 'required'
       ]);

       $data = [
        'gateway_currency' => $request->gateway_currency,
        'paypal_client_id' => $request->paypal_client_id,
        'paypal_client_secret' => $request->paypal_client_secret,
        'mode' => $request->mode
       ];


       if($gateway){
           if($request->hasFile('paypal_image')){
               $filename = uploadImage($request->paypal_image,filePath('gateways'), $gateway->gateway_image );
           }


           $gateway->update([
               'gateway_image' => $filename ?? $gateway->gateway_image,
               'gateway_parameters' => $data,
               'gateway_type' => 1,
               'status' => $request->status,
               'rate' => $request->rate
           ]);


           $notify[] = ['success', "Paypal Setting Updated Successfully"];

           return redirect()->back()->withNotify($notify);

       }


       if($request->hasFile('paypal_image')){
            $filename = uploadImage($request->paypal_image,filePath('gateways'));
        }



       Gateway::create([
            'gateway_name' => 'paypal',
            'gateway_image' => $filename  ,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'status' => $request->status,
            'rate' => $request->rate,
       
       ]);


       $notify[] = ['success', "Paypal Setting Updated Successfully"];

       return redirect()->back()->withNotify($notify);
    }
    
    public function stripe()
    {
        $pageTitle = 'Stripe Payment';

        $gateway = Gateway::where('gateway_name', 'stripe')->first();

        return view('admin.gateways.stripe',compact('pageTitle','gateway'));
    }


    public function stripeUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'stripe')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'stripe_client_id' => 'required',
            'stripe_client_secret' => 'required',
            'stripe_image' => [Rule::requiredIf(function() use($gateway){ return $gateway == null ;}),'image','mimes:jpg,png,jpeg'],
            'status' => 'required',
            'rate'=> 'required',
            
        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'stripe_client_id' => $request->stripe_client_id,
            'stripe_client_secret' => $request->stripe_client_secret,
           ];
    
    
           if($gateway){
               if($request->hasFile('stripe_image')){
                   $filename = uploadImage($request->stripe_image,filePath('gateways'), $gateway->gateway_image );
               }
    
    
               $gateway->update([
                   'gateway_image' => $filename ?? $gateway->gateway_image,
                   'gateway_parameters' => $data,
                   'gateway_type' => 1,
                   'status' => $request->status,
                   'rate' => $request->rate,
                   
               ]);
    
    
               $notify[] = ['success', "Stripe Setting Updated Successfully"];
    
               return redirect()->back()->withNotify($notify);
    
           }
    
    
           if($request->hasFile('stripe_image')){
                $filename = uploadImage($request->stripe_image,filePath('gateways'));
            }
    
    
    
           Gateway::create([
                'gateway_name' => 'stripe',
                'gateway_image' => $filename  ,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'status' => $request->status,
                'rate' => $request->rate,
                
           ]);
    
    
           $notify[] = ['success', "Stripe Setting Updated Successfully"];
    
           return redirect()->back()->withNotify($notify);
    }


    public function vouguepay()
    {
        $pageTitle = 'Vouguepay Payment';

        $gateway = Gateway::where('gateway_name', 'vouguepay')->first();

        return view('admin.gateways.vouguepay',compact('pageTitle','gateway'));
    }

    public function vouguepayUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'vouguepay')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'vouguepay_merchant_id' => 'required',
            'vouguepay_image' => [Rule::requiredIf(function() use($gateway){ return $gateway == null ;}),'image','mimes:jpg,png,jpeg'],
            'status' => 'required'
        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'vouguepay_merchant_id' => $request->vouguepay_merchant_id
           ];
    
    
           if($gateway){
               if($request->hasFile('vouguepay_image')){
                   $filename = uploadImage($request->vouguepay_image,'admin/images/gateways','200x200', $gateway->gateway_image );
               }
    
    
               $gateway->update([
                   'gateway_image' => $filename ?? $gateway->gateway_image,
                   'gateway_parameters' => $data,
                   'gateway_type' => 1,
                   'status' => $request->status
               ]);
    
    
               $notify[] = ['success', "VouguePay Setting Updated Successfully"];
    
               return redirect()->back()->withNotify($notify);
    
           }
    
    
           if($request->hasFile('vouguepay_image')){
                $filename = uploadImage($request->vouguepay_image,'admin/images/gateways','200x200');
            }
    
    
    
           Gateway::create([
                'gateway_name' => 'vouguepay',
                'gateway_image' => $filename  ,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'status' => $request->status
           ]);
    
    
           $notify[] = ['success', "VouguePay Setting Updated Successfully"];
    
           return redirect()->back()->withNotify($notify);
    }

    public function manualPayment()
    {
        $pageTitle = "Manual Payments";

        $manuals = Booking::where('payment_type',0)->latest()->with('service','user')->paginate();

        return view('admin.manual_payments.index',compact('pageTitle','manuals'));
    }

    public function manualPaymentDetails (Request $request)
    {
        $pageTitle = "Payment Details";

        $manual = Booking::where('trx',$request->trx)->firstOrFail();

        return view('admin.manual_payments.details',compact('pageTitle','manual'));
    }

    public function manualPaymentAccept(Request $request)
    {
        $booking = Booking::where('trx', $request->trx)->firstOrFail();
        $general = GeneralSetting::first();
        $gateway = Gateway::where('gateway_name','bank')->first();

        $booking->payment_confirmed = 1;
        $booking->save();

        $adminCommision = ($booking->amount * $general->commission) / 100;

        $userAmount = $booking->amount - $adminCommision;

        $booking->service->user->balance = $booking->service->user->balance + $userAmount;
        $booking->service->user->save();

        
        Transaction::create([
            'trx' => $booking->trx,
            'user_id' => $booking->user_id,
            'service_id' => $booking->service_id,
            'amount' => $booking->amount,
            'currency' => $general->site_currency,
            'details' => 'Payment Accepted for '.$booking->service->name,
            'charge' => $gateway->charge,
            'type' => '-'
        ]);
        
        Transaction::create([
            'trx' => $booking->trx,
            'user_id' => $booking->service->user->id,
            'service_id' => $booking->service_id,
            'amount' => $booking->amount,
            'currency' => $general->site_currency,
            'details' => 'Paid for '.$booking->service->name,
            'charge' => $gateway->charge,
            'type' => '+'
        ]);

        sendMail('PAYMENT_CONFIRMED',['trx'=>$booking->trx,'amount'=>$booking->amount,'charge' => number_format($booking->charge,4),'service'=>$booking->name,'currency' => $general->site_currency ], $booking->user); 
        
        sendMail('PAYMENT_RECEIVED',['trx'=>$booking->trx,'amount'=>$userAmount,'charge' => number_format($booking->charge,4),'service'=>$booking->name,'currency' => $general->site_currency], $booking->service->user);


        $notify[] = ['success', "Payment Confirmed Successfully"];
    
        return redirect()->back()->withNotify($notify);

    }

    public function manualPaymentReject(Request $request)
    {
        $manual = Booking::where('trx', $request->trx)->firstOrFail();
        $general = GeneralSetting::first();

        $manual->payment_confirmed = 3;

        $manual->save();


        sendMail('PAYMENT_REJECTED',['trx'=>$manual->trx,'amount'=>$manual->amount,'charge' => $manual->charge,'service'=>$manual->name,'currency' => $general->site_currency ], $manual->user); 

        $notify[] = ['success', "Payment Rejected Successfully"];
    
        return redirect()->back()->withNotify($notify);
 
    }

   

}
