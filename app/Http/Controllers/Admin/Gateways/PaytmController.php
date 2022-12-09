<?php

namespace App\Http\Controllers\Admin\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PaytmWallet;

class PaytmController extends Controller
{
    public function paytmPayment(Request $request)
    {
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => rand(),
          'user' => rand(10,1000),
          'mobile_number' => '123456789',
          'email' => 'paytmtest@gmail.com',
          'amount' => $request->amount,
          'callback_url' => route('paytm.callback'),
        ]);
       
        return $payment->receive();

       
    }

    public function paytmCallback()
    {
        $transaction = PaytmWallet::with('receive');
        
        $response = $transaction->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        
        if($transaction->isSuccessful()){
          return view('paytm.paytm-success-page');
        }else if($transaction->isFailed()){
         
          return 'failed';
        }else if($transaction->isOpen()){
          return 'processing';
        }
        $transaction->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $transaction->getOrderId(); // Get order id
        $transaction->getTransactionId(); // Get transaction id
    }

    public function paytmPurchase()
    {
        return view('paytm.payment-page');
    } 
}
