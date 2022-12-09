@extends('frontend.layout.frontend')
@section('breadcumb')

@php

    $content = content('breadcrumb.content');

@endphp
<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{getFile('breadcrumb',@$content->data->image)}});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@changeLang('Password Reset')</h1>
                    <ul>
                        <li><a href="{{route('home')}}">@changeLang('Home')</a></li>
                        <li><span>@changeLang('Password Reset')</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->
@endsection
@section('content')

 @push('seo')
        <meta name='description' content="{{ @$general->seo_description }}">
    @endpush

<div class="container padding-top-bottom-50">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow">

                    <div class="card-body">


                        <form action="{{ route('user.reset.password') }}" method="POST">

                            @csrf
                            <div class="row justify-content-center">

                                <input type="hidden" name="email" value="{{ $session['email'] }}">

                                <div class="form-group col-md-12">

                                    <label for="">@changeLang('New Password')</label>
                                    <input type="password" name="password" class="form-control" >

                                </div>

                                <div class="form-group col-md-12">

                                    <label for="">@changeLang('Confirm Password')</label>
                                    <input type="password" name="password_confirmation" class="form-control" >

                                </div>

                                 @if (@$general->allow_recaptcha)

                                    <div class="col-md-12 my-3">
                                    
                                    <script src="https://www.google.com/recaptcha/api.js"></script>
                                    <div class="g-recaptcha" data-sitekey="{{ @$general->recaptcha_key }}"
                                        data-callback="verifyCaptcha"></div>
                                    <div id="g-recaptcha-error"></div>
                                    </div>

                                @endif


                                <div class="col-md-12">

                                    <button type="submit" id="recaptcha" class="btn  btn-base ">@changeLang('Reset Password')</button>
                                </div>

                                <div class="col-md-12 mt-4">

                                    <p>@changeLang('Login Again')? <a href="{{ route('user.login') }}"
                                            class="text-primary">@changeLang('Login')</a></p>

                                </div>



                            </div>


                        </form>


                    </div>



                </div>


            </div>



        </div>


    </div>

@endsection


@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =  "<span class='text-danger'>@changeLang('Captcha field is required.')</span>";
                return false;
            }
            return true;
        }
        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush