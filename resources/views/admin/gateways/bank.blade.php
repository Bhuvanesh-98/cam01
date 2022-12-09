@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Bank Payment Gateway')</h1>
      
          
        
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
                                <label class="col-form-label">@changeLang('Bank Image')</label>

                                <div id="image-preview" class="image-preview"
                                    style="background-image:url({{ getFile('gateways' , @$gateway->gateway_image) }});">
                                    <label for="image-upload" id="image-label">@changeLang('Choose File')</label>
                                    <input type="file" name="bank_image" id="image-upload" />
                                </div>

                            </div>

                            <div class="col-md-9">

                                <div class="row">

                                    <div class="form-group col-md-6">

                                        <label for="">@changeLang('Bank Name')</label>
                                        <input type="text" name="name"  class="form-control"
                                            value="{{ @$gateway->gateway_parameters->name }}">

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="">@changeLang('Bank Account Number')</label>
                                        <input type="text" name="account_number"
                                            class="form-control"
                                            value="{{ @$gateway->gateway_parameters->account_number }}">

                                    </div>



                                    <div class="form-group col-md-6">

                                        <label for="">@changeLang('Bank Routing Number')</label>
                                        <input type="text" name="routing_number" 
                                            class="form-control"
                                            value="{{ @$gateway->gateway_parameters->routing_number }}">

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="">@changeLang('Bank Branch Name')</label>
                                        <input type="text" name="branch_name" 
                                            class="form-control" value="{{ @$gateway->gateway_parameters->branch_name }}">

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="">@changeLang('Gateway Currency')</label>
                                        <input type="text" name="gateway_currency" class="form-control site-currency"
                                            
                                            value="{{ $gateway->gateway_parameters->gateway_currency ?? '' }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>@changeLang('Conversion Rate')</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    {{"1 ".$general->site_currency.' = '}}
                                                </div>
                                            </div>
                                            <input type="text" class="form-control currency" name="rate"  value="{{number_format(@$gateway->rate,4) ?? 0}}">

                                            <div class="input-group-append">
                                                <div class="input-group-text append_currency">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    <div class="form-group col-md-6">
                                        <label>@changeLang('Charge')</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    {{$general->site_currency}}
                                                </div>
                                            </div>
                                            <input type="text" class="form-control currency" name="charge"  value="{{number_format(@$gateway->charge,4) ?? 0}}">

                                            
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="">@changeLang('Allow as payment method')</label>

                                        <select name="status" id="" class="form-control">

                                            <option value="1" {{ @$gateway->status ? 'selected' : '' }}>@changeLang('Yes')
                                            </option>
                                            <option value="0" {{ @$gateway->status ? '' : 'selected' }}>@changeLang('No')
                                            </option>


                                        </select>

                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="card">

                                    <div class="card-header bg-primary">

                                        <h6 class="text-white">@changeLang('User Proof Requirements')</h6>

                                        <button type="button" class="btn btn-dark ml-auto payment"> <i
                                                class="fa fa-plus text-white"></i>
                                            @changeLang('Add Payment Requirements')</button>

                                    </div>

                                    <div class="card-body">

                                        <div class="row payment-instruction">

                                            <div class="col-md-12 user-data">
                                                <div class="row">


                                                    @if (@$gateway->user_proof_param != null)


                                                        @foreach ($gateway->user_proof_param as $key => $param)
                
                                                            <div class="col-md-12 user-data">
                                                                <div class="form-group">
                                                                    <div class="input-group mb-md-0 mb-4">
                                                                        <div class="col-md-4">
                                                                            <label>@changeLang('Field Name')</label>
                                                                            <input
                                                                                name="user_proof_param[{{ $key }}][field_name]"
                                                                                class="form-control form_control"
                                                                                type="text"
                                                                                value="{{ $param['field_name'] }}"
                                                                                required >
                                                                        </div>
                                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                                            <label>@changeLang('Field Type')</label>
                                                                            <select
                                                                                name="user_proof_param[{{ $key }}][type]"
                                                                                class="form-control">
                                                                                <option value="text"
                                                                                    {{ $param['type'] == 'text' ? 'selected' : '' }}>
                                                                                    @changeLang('Input Text')
                                                                                </option>
                                                                                <option value="textarea"
                                                                                    {{ $param['type'] == 'textarea' ? 'selected' : '' }}>
                                                                                    @changeLang('Textarea')
                                                                                </option>
                                                                                <option value="file"
                                                                                    {{ $param['type'] == 'file' ? 'selected' : '' }}>
                                                                                    @changeLang('File upload')
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                                            <label>@changeLang('Field Validation')</label>
                                                                            <select
                                                                                name="user_proof_param[{{ $key }}][validation]"
                                                                                class="form-control">
                                                                                <option value="required"
                                                                                    {{ $param['validation'] == 'required' ? 'selected' : '' }}>
                                                                                    @changeLang('Required')
                                                                                </option>
                                                                                <option value="nullable"
                                                                                    {{ $param['validation'] == 'nullable' ? 'selected' : '' }}>
                                                                                    @changeLang('Optional')
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div
                                                                            class="col-md-2 text-right my-auto ">

                                                                            <button
                                                                                class="btn btn-danger btn-lg remove w-100 mt-4"
                                                                                type="button">
                                                                                <i class="fa fa-times"></i>
                                                                            </button>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach


                                                    @endif
                                                </div>

                                            </div>


                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary w-100">
                                @changeLang('Update Bank Information')</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>


    </div>


@endsection

@push('custom-script')

    <script>
        $(function() {
            'use strict'

            var i = {{count($gateway->user_proof_param ?? [])}};

            $('.payment').on('click', function() {

                var html = `
                <div class="col-md-12 user-data">
                    <div class="form-group">
                        <div class="input-group mb-md-0 mb-4">
                            <div class="col-md-4">
                                <label>@changeLang('Field Name')</label>
                                <input name="user_proof_param[${i}][field_name]" class="form-control form_control" type="text" value="" required >
                            </div>
                            <div class="col-md-3 mt-md-0 mt-2">
                                <label>@changeLang('Field Type')</label>
                                <select name="user_proof_param[${i}][type]" class="form-control">
                                    <option value="text" > @changeLang('Input Text') </option>
                                    <option value="textarea" > @changeLang('Textarea') </option>
                                    <option value="file"> @changeLang('File upload') </option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-md-0 mt-2">
                                <label>@changeLang('Field Validation')</label>
                                <select name="user_proof_param[${i}][validation]"
                                        class="form-control">
                                    <option value="required"> @changeLang('Required') </option>
                                    <option value="nullable">  @changeLang('Optional') </option>
                                </select>
                            </div>
                            <div class="col-md-2 text-right my-auto">
                              
                                    <button class="btn btn-danger btn-lg remove w-100 mt-4" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                
                            </div>
                        </div>
                    </div>
                </div>`;
                $('.payment-instruction').append(html);

                i++;

            })

            $(document).on('click', '.remove', function() {
                $(this).closest('.user-data').remove();
            });

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
