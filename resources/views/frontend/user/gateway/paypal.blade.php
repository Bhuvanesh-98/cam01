@extends('frontend.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Paypal Payment')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="card credit-card-box">
                <div class="card-header text-center">
                    <h5>@changeLang('Payment Preview')</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">

                        <li class="list-group-item d-flex justify-content-between">
                            <span>@changeLang('Service Name'):</span>
                            <span>{{$booking->service->name}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>@changeLang('Amount'):</span>
                            <span>{{$booking->amount.' '.$general->site_currency}}</span>
                        </li> 
                        
                        <li class="list-group-item d-flex justify-content-between">
                            <span>@changeLang('Conversion Rate'):</span>
                            <span>{{"1 $general->site_currency = " . number_format($gateway->rate,4).' '.$gateway->gateway_parameters->gateway_currency}}</span>
                        </li>
                        
                       
                        
                        <li class="list-group-item d-flex justify-content-between">
                            <span>@changeLang('Total Payable Amount'):</span>
                            <span>{{ ($booking->amount * $gateway->rate).' '.$gateway->gateway_parameters->gateway_currency}}</span>
                        </li> 
                        
                        <li class="list-group-item">
                            <form action="{{ route('user.paypal.post',[$booking,$gateway]) }}" method="post">
                             @csrf
                                <input type="hidden" name="amount" value="{{($booking->amount * $gateway->rate) + $gateway->charge}}">
                                <button type="submit" class="btn btn-primary ">@changeLang('Pay With Paypal')</button>
                            
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection