@extends('frontend.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Payment Gateways')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-md-12">


            <div class="card">


                <div class="card-body">

                    <div class="row">

                        @foreach ($gateways as $gateway)

                            <div class="col-md-4">
                                <div class="thumbnail">
                                    
                                        <div class="image-area">
                                            <img src="{{ getFile('gateways' , $gateway->gateway_image) }}"
                                            alt="Lights" class="w-100 gateway-image">
                                        </div>
                                        <div class="caption text-center mt-3">
                                            <form action="" method="post">
                                                @csrf
                                                <input type="hidden" name="gateway" id="" value="{{$gateway->id}}">
                                                <button type="submit" class="btn btn-primary">
                                                {{changeDynamic('Pay Via '.$gateway->gateway_name)}}</button>
                                            </form>
                                        </div>
                                    
                                </div>
                            </div>
                        @endforeach



                    </div>

                </div>




            </div>


        </div>

    </div>

@endsection

@push('custom-style')

<style>
    .image-area{
       height:300px;
    }
    .gateway-image{
        width:100%;
        height:100%;
        object-fit:cover;
    }


</style>
    
@endpush