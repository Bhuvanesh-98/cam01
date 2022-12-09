@extends('frontend.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Bank Payment')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')


<div class="row">


    <div class="col-md-12">
    
    
        <div class="row">


        
            <div class="col-md-6">
            

                <div class="card">
                
                
                    <div class="card-header">

                        <h4>@changeLang('Bank Payment Information')</h4>

                    </div>

                    <div class="card-body">
                    

                        <ul class="list-group">

                            <li class="list-group-item d-flex justify-content-between">
                                <span>@changeLang('Bank Name')</span>
                                <span>{{$gateway->gateway_parameters->name}}</span>
                            </li> 
                            
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@changeLang('Account Number')</span>
                                <span>{{$gateway->gateway_parameters->account_number}}</span>
                            </li>
                            
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@changeLang('Routing Number')</span>
                                <span>{{$gateway->gateway_parameters->routing_number}}</span>
                            </li>
                            
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@changeLang('Branch Name')</span>
                                <span>{{$gateway->gateway_parameters->branch_name}}</span>
                            </li> 
                            
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@changeLang('Method Currency')</span>
                                <span>{{$gateway->gateway_parameters->gateway_currency}}</span>
                            </li>
                        
                        </ul>
                    
                    
                    
                    </div>
                
                
                
                </div>
                
            
            
            </div>
            
            <div class="col-md-6">
            

                <div class="card">
                
                
                    <div class="card-header">

                        <h4>@changeLang('Payment Information')</h4>

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
                            <span>@changeLang('Gateway Charge'):</span>
                            <span>{{ number_format($gateway->charge,2) .' '.$general->site_currency}}</span>
                        </li>
                       
                        <li class="list-group-item d-flex justify-content-between">
                            <span>@changeLang('Total Payable Amount'):</span>
                            <span>{{ ($booking->amount * $gateway->rate) + ($gateway->charge * $gateway->rate).' '.$gateway->gateway_parameters->gateway_currency}}</span>
                        </li> 
                        
                        </ul>
                    
                    
                    
                    </div>
                
                
                
                </div>
                
            
            
            </div>

            <div class="col-md-12">
            
                <div class="card">

                    <div class="card-header"><h4>@changeLang('Payment Proof')</h4></div>

                    <div class="card-body">
                    
                        <form action="{{route('user.bank.post', [$booking, $gateway->gateway_name])}}" method="post" enctype="multipart/form-data"> 
                        @csrf
                        
                        
                        <div class="row">
                        
                        @foreach ($gateway->user_proof_param as $proof)
                            @if($proof['type'] == 'text')

                                <div class="form-group col-md-12">
                                    <label for="">{{__($proof['field_name'])}}</label>
                                    <input type="text" name="{{strtolower(str_replace(' ', '_',$proof['field_name']))}}" class="form-control" {{$proof['validation'] == 'required' ? 'required' :''}} >
                                </div>

                            @endif
                            @if($proof['type'] == 'textarea')

                                <div class="form-group col-md-12">
                                    <label for="">{{__($proof['field_name'])}}</label>
                                    <textarea name="{{strtolower(str_replace(' ', '_',$proof['field_name']))}}" class="form-control" {{$proof['validation'] == 'required' ? 'required' :''}} ></textarea>
                                </div>

                            @endif 
                            
                            @if($proof['type'] == 'file')

                                <div class="form-group col-md-12">
                                    <label for="">{{__($proof['field_name'])}}</label>
                                     <input type="file" name="{{strtolower(str_replace(' ', '_',$proof['field_name']))}}" class="form-control" {{$proof['validation'] == 'required' ? 'required' :''}} >                             
                                </div>

                            @endif
                        @endforeach
                            
                        
                        <div class="form-group">
                        
                            <button class="btn btn-primary" type="submit">@changeLang('Send Proof For Payment ')</button>
                        
                        
                        </div>
                        
                        
                        </div>
                        
                        
                        
                        </form>
                    
                    
                    
                    </div>
                
                </div>
            
            
            
            
            </div>
        
        
        </div>
    
    
    
    </div>


</div>



@endsection