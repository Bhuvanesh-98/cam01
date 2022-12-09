@extends('frontend.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Withdraw')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')


    <div class="row">




        <div class="col-md-6 col-12">


            <div class="card">


                <div class="card-body">



                    <form action="" method="post">

                        @csrf

                        <div class="row">


                            <div class="col-md-12 mb-3">

                                <h5 class="font-weight-bolder">@changeLang('Current Balance: '){{number_format(auth()->user()->balance,3).' '.$general->site_currency}}</h5>
                            
                            </div>


                            <div class="form-group col-md-12">

                                <label for="">@changeLang('Withdraw Method')</label>

                                <select name="method" id="" class="form-control">
                                    <option value="" selected>@changeLang('Select Method')</option>
                                    @foreach ($withdraws as $withdraw)
                                        <option value="{{ $withdraw->id }}"
                                            data-url="{{ route('user.withdraw.fetch', $withdraw->id) }}">
                                            {{ $withdraw->name }}</option>
                                    @endforeach

                                </select>




                            </div>

                            <div class="form-group col-md-12">
                                <div class="row appendData"></div>
                            </div>




                        </div>




                    </form>


                </div>





            </div>





        </div>

        <div class="col-md-6 col-12">

            <div class="card">

                <div class="card-header">

                    <h4>@changeLang('Withdraw Instruction')</h4>
                
                </div>
                <div class="card-body">
                
                    <p class="instruction">
                    
                    
                    
                    </p>
                
                
                </div>
            
            
            </div>
        
        </div>



    </div>





@endsection


@push('custom-script')

    <script>
        $(function() {
            'use strict'

            $('select[name=method]').on('change', function() {
                if($(this).val() == ''){
                    $('.appendData').addClass('d-none');
                    $('.instruction').text('');
                    return;
                }
                $('.appendData').removeClass('d-none');
                getData($('select[name=method] option:selected').data('url'))
            })

            $(document).on('keyup', '.amount', function(){
                const withdraw_charge_type = $('.withdraw_charge_type').text();

                if($(this).val() == ''){
                    $('.final_amo').val(0);
                    return
                }
                
                const charge = $('.charge').val();
               
                if(withdraw_charge_type.localeCompare("percent") == 1){
                    let percentAmount = Number.parseFloat($(this).val()) + Number.parseFloat((charge * $(this).val()) / 100);

                    $('.final_amo').val(percentAmount.toFixed(2));
                    return
                }
                if(withdraw_charge_type.localeCompare("fixed") == 1){
                   
                    let totalAmount = Number.parseFloat($(this).val()) + Number.parseFloat(charge);

                    $('.final_amo').val(totalAmount);
                }


                
            })

            function getData(url) {
                $.ajax({
                    url: url,
                    method: "GET",
                    success: function(response) {

                        $('.instruction').html(response.withdraw_instruction)
                        let html = `
                   
                         <div class="form-group col-md-12">
                                    <label for="">@changeLang('Withdraw Min Amount')</label>
                                    <input type="text" name="min_amount" class="form-control" value="${response.min_withdraw}" required disabled>
                                </div> 
                                
                                <div class="form-group col-md-12">
                                    <label for="">@changeLang('Withdraw Max Amount')</label>
                                    <input type="text" name="max_amount" class="form-control" value="${response.max_withdraw}" required disabled>
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <label for="">@changeLang('Available Balance')</label>
                                    <input type="text" name="balance" class="form-control" value="{{ number_format(auth()->user()->balance,2) }}" required disabled>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>@changeLang('Withdraw Charge')</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="withdraw_charge_type">${response.charge_type}<span>
                                        </div>
                                        </div>
                                        <input type="text" class="form-control charge" value="${Number.parseFloat(response.charge).toFixed()}" required disabled>
                                    </div>
                                </div> 
                                
                                 <div class="form-group col-md-12">
                                    <label for="">@changeLang('Withdraw Amount') <span class="text-danger">*</span></label>
                                    <input type="text" name="amount" class="form-control amount" required>
                                </div> 
                                
                                <div class="form-group col-md-12">
                                    <label for="">@changeLang('Final Withdraw Amount') <span class="text-danger">*</span></label>
                                    <input type="text" name="final_amo" class="form-control final_amo" required>
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <label for="">@changeLang('Account Email') <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>  
                                
                                <div class="form-group col-md-12">
                                    <label for="">@changeLang('Account Information')</label>
                                   <textarea class="form-control" name="account_information" row="5"></textarea>
                                </div> 
                                
                                <div class="form-group col-md-12">
                                    <label for="">@changeLang('Additional Note')</label>
                                   <textarea class="form-control" name="note" row="5"></textarea>
                                </div> 
                                
                                <div class="form-group col-md-12">
                                    
                                   <button class="btn btn-primary" type="submit">@changeLang('Withdraw Now')</button>
                                </div>
                   
                   
                   `;

                        $('.appendData').html(html);
                    }
                })
            }
        })
    </script>

@endpush
