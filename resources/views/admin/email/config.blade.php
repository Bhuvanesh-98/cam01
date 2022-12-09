@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Email Configure')</h1>
      
          
        
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
                            <div class="form-group col-md-6">

                                <label for="">@changeLang('Email Method')</label>
                                <select name="email_method" id="" class="form-control">

                                    <option value="php" {{ $general->email_method == 'php' ? 'selected' : '' }}>@changeLang('PHPMail')</option>
                                    <option value="smtp" {{ $general->email_method == 'smtp' ? 'selected' : '' }}>
                                        @changeLang('SMTP Mail')</option>

                                </select>

                            </div>

                            <div class="form-group col-md-6">

                                <label for="">@changeLang('Email Sent From')</label>

                                <input type="email" name="email_from" class="form-control form_control"  value="{{$general->email_from}}">

                            </div>

                            <div class="form-group col-md-12 smtp-config">

                                @if ($general->email_method == 'smtp')

                                    <div class="row">

                                        <div class="col-md-3">

                                            <label for="">@changeLang('SMTP HOST')</label>
                                            <input type="text" name="smtp_config[smtp_host]"
                                                 class="form-control"
                                                value="{{ @$general->smtp_config->smtp_host }}">

                                        </div>

                                        <div class="col-md-3">

                                            <label for="">@changeLang('SMTP Username')</label>
                                            <input type="text" name="smtp_config[smtp_username]"
                                                 class="form-control"
                                                value="{{ @$general->smtp_config->smtp_username }}">

                                        </div>

                                        <div class="col-md-3">

                                            <label for="">@changeLang('SMTP Password')</label>
                                            <input type="text" name="smtp_config[smtp_password]"
                                                 class="form-control"
                                                value="{{ @$general->smtp_config->smtp_password }}">

                                        </div>
                                        <div class="col-md-3">

                                            <label for="">@changeLang('SMTP port')</label>
                                            <input type="text" name="smtp_config[smtp_port]"
                                                 class="form-control"
                                                value="{{ @$general->smtp_config->smtp_port }}">

                                        </div>

                                        <div class="col-md-6 mt-3">

                                            <label for="">@changeLang('SMTP Encryption')</label>
                                            <select name="smtp_config[smtp_encryption]" id="encryption" class="form-control">
                                                <option value="ssl"
                                                    {{ @$general->smtp_config->smtp_encryption == 'ssl' ? 'selected' : '' }}>
                                                    @changeLang('SSL')</option>
                                                <option value="tls"
                                                    {{ @$general->smtp_config->smtp_encryption == 'tls' ? 'selected' : '' }}>
                                                    @changeLang('TLS')</option>
                                            </select>

                                            <code class="hint"></code>

                                        </div>

                                    </div>


                                @endif

                            </div>

                            <div class="form-group col-md-12">

                                <button type="submit" class="btn btn-primary">@changeLang('Update Email Configuration')</button>

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

            $('select[name=email_method]').on('change', function() {
                if ($(this).val() == 'smtp') {
                    var html = `
                
                     <div class="row">

                                    <div class="col-md-3">

                                        <label for="">@changeLang('SMTP HOST')</label>
                                        <input type="text" name="smtp_config[smtp_host]"  class="form-control" value="{{ @$general->smtp_config->smtp_host }}">

                                    </div> 
                                    
                                    <div class="col-md-3">

                                        <label for="">@changeLang('SMTP Username')</label>
                                        <input type="text" name="smtp_config[smtp_username]"  class="form-control" value="{{ @$general->smtp_config->smtp_username }}">

                                    </div>
                                    
                                    <div class="col-md-3">

                                        <label for="">@changeLang('SMTP Password')</label>
                                        <input type="text" name="smtp_config[smtp_password]"  class="form-control" value="{{ @$general->smtp_config->smtp_password }}">

                                    </div>
                                    <div class="col-md-3">

                                        <label for="">@changeLang('SMTP port')</label>
                                        <input type="text" name="smtp_config[smtp_port]"  class="form-control" value="{{ @$general->smtp_config->smtp_port }}">

                                    </div> 
                                    
                                    <div class="col-md-6 mt-3">

                                        <label for="">@changeLang('SMTP Encryption')</label>
                                       <select name="smtp_config[smtp_encryption]" id="" class="form-control">
                                        <option value="ssl" {{ @$general->smtp_config->smtp_encription == 'ssl' ? 'selected' : '' }}>@changeLang('SSL')</option>
                                        <option value="tls" {{ @$general->smtp_config->smtp_encription == 'tls' ? 'selected' : '' }}>@changeLang('TLS')</option>
                                       </select>

                                    </div>
                                
                                </div>
                
                `;

                    $('.smtp-config').html(html)

                } else {
                    $('.smtp-config').html('')
                }
            })

            $('#encryption').on('change',function(){
                if($(this).val() == 'ssl'){
                    $('.hint').text("For SSL please add ssl:// before host otherwise it won't work")
                }else{
                    $('.hint').text('')
                }
            })
        })
    </script>

@endpush
