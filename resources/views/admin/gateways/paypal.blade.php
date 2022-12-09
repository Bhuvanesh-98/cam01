@extends('admin.layout.master')

@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Paypal Payment Gateway')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <div class="form-group col-md-3 mb-3">
                                <label class="col-form-label">@changeLang('Paypal Image')</label>

                                <div id="image-preview" class="image-preview"
                                    style="background-image:url({{ getFile('gateways' , @$gateway->gateway_image) }});">
                                    <label for="image-upload" id="image-label">@changeLang('Choose File')</label>
                                    <input type="file" name="paypal_image" id="image-upload" />
                                </div>

                            </div>

                            <div class="col-md-9">

                                <div class="row">


                                    <div class="form-group col-md-4">

                                        <label for="">@changeLang('Gateway Currency')</label>
                                        <input type="text" name="gateway_currency" class="form-control form_control site-currency"
                                            
                                            value="{{ @$gateway->gateway_parameters->gateway_currency ?? old('gateway_currency') }}">
                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="">@changeLang('Paypal Account Mode')</label>
                                       <select name="mode" id="" class="form-control">
                                        <option value="sandbox" {{@$gateway->gateway_parameters->mode == 'sandbox' ? 'selected' : ''}}>@changeLang('Sandbox')</option>
                                        <option value="live" {{@$gateway->gateway_parameters->mode == 'live' ? 'selected' : ''}}>@changeLang('Live')</option>
                                       </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>@changeLang('Conversion Rate')</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    {{"1 ".$general->site_currency.' = '}}
                                                </div>
                                            </div>
                                            <input type="text" class="form-control currency" name="rate" value="{{number_format($gateway->rate,4) ?? 0}}">

                                            <div class="input-group-append">
                                                <div class="input-group-text append_currency">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    

                                    <div class="form-group col-md-12">

                                        <label for="">@changeLang('Paypal Client id')</label>
                                        <input type="text" name="paypal_client_id" class="form-control"
                                            
                                            value="{{ $gateway->gateway_parameters->paypal_client_id ?? old('paypal_client_id') }}">
                                    </div>

                                    <div class="form-group col-md-12">

                                        <label for="">@changeLang('Paypal Client Secret')</label>
                                        <input type="text" name="paypal_client_secret" class="form-control"
                                            
                                            value="{{ $gateway->gateway_parameters->paypal_client_secret ?? old('paypal_client_secret') }}">
                                    </div>

                                    <div class="form-group col-md-12">

                                        <label for="">@changeLang('Allow as payment method')</label>

                                        <select name="status" id="" class="form-control">

                                            <option value="1" {{ @$gateway->status ? 'selected' : '' }}>@changeLang('Yes')
                                            </option>
                                            <option value="0" {{ @$gateway->status ? '' : 'selected' }}>@changeLang('No')</option>


                                        </select>

                                    </div>



                                </div>



                            </div>


                            <button type="submit" class="btn btn-primary w-100">@changeLang('Update Paypal Information')</button>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>




@endsection


@push('custom-script')

    <script>
     $(function(){
         'use strict'
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "{{changeDynamic('Choose File')}}", // Default: Choose File
            label_selected: "{{changeDynamic('Update Image')}}", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

          $('.site-currency').on('keyup',function(){
            $('.append_currency').text($(this).val())
        })

        $('.append_currency').text($('.site-currency').val())
     })
    </script>

@endpush
