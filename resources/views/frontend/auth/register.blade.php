@extends('frontend.layout.frontend')
@section('breadcumb')

    @php

    $content = content('breadcrumb.content');

    @endphp
    <!--Banner Start-->
    <div class="banner-area flex"
        style="background-image:url({{getFile('breadcrumb',@$content->data->image)}});">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner-text">
                        <h1>@changeLang('Register')</h1>
                        <ul>
                            <li><a href="{{ route('home') }}">@changeLang('Home')</a></li>
                            <li><span>@changeLang('Register')</span></li>
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

            <div class="col-md-8">

                <div class="card shadow">

                    <div class="card-body">


                        <form action="" method="POST">

                            @csrf
                            <div class="row justify-content-center">

                                <div class="form-group col-md-12 d-flex">


                                    <input type="radio" name="user_type" id="option-1" value="1" checked>
                                    <input type="radio" name="user_type" id="option-2" value="2">
                                    <label for="option-1" class="option option-1">
                                        <div class="dot"></div>
                                        <span>@changeLang('User')</span>
                                    </label>
                                    <label for="option-2" class="option option-2">
                                        <div class="dot"></div>
                                        <span>@changeLang('Service Provider')</span>
                                    </label>


                                </div>

                                <div class="form-group col-md-6">

                                    <label for="">@changeLang('First Name') <span class="text-danger">*</span></label>
                                    <input type="text" name="fname" class="form-control">

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="">@changeLang('Last Name')<span class="text-danger">*</span></label>
                                    <input type="text" name="lname" class="form-control">

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="">@changeLang('Username')<span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control" id="input-field">

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="">@changeLang('Email Address')<span class="text-danger">*</span></label>
                                    <input type="text" name="email" class="form-control">

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="">@changeLang('Password')<span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control">

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="">@changeLang('Confirm Password')<span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control">

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
                                    <button type="submit" id="recaptcha" class="btn btn-base w-100">@changeLang('Register Now')</button>
                                </div>

                                <div class="col-md-12 mt-4">

                                    <p>@changeLang('Registered Already')? <a href="{{ route('user.login') }}"
                                            class="text-primary">@changeLang('Login here')</a></p>

                                </div>

                            </div>


                        </form>


                    </div>



                </div>


            </div>



        </div>


    </div>


@endsection

@push('custom-css')

    <style>
        .option {
            background: #fff;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            margin: 0 10px;
            border-radius: 5px;
            cursor: pointer;
            padding: 0 10px;
            border: 2px solid lightgrey;
            transition: all 0.3s ease;
        }

        .option .dot {
            height: 20px;
            width: 20px;
            background: #d9d9d9;
            border-radius: 50%;
            position: relative;
        }

        .option .dot::before {
            position: absolute;
            content: "";
            top: 4px;
            left: 4px;
            width: 12px;
            height: 12px;
            background: #5f3afc;
            border-radius: 50%;
            opacity: 0;
            transform: scale(1.5);
            transition: all 0.3s ease;
        }

        input[type="radio"] {
            display: none;
        }

        #option-1:checked:checked~.option-1,
        #option-2:checked:checked~.option-2 {
            border-color: #5f3afc;
            background: #5f3afc;
        }

        #option-1:checked:checked~.option-1 .dot,
        #option-2:checked:checked~.option-2 .dot {
            background: #fff;
        }

        #option-1:checked:checked~.option-1 .dot::before,
        #option-2:checked:checked~.option-2 .dot::before {
            opacity: 1;
            transform: scale(1);
        }

        .option span {
            font-size: 14px;
            padding: 10px 5px;
            color: #808080;
        }

        #option-1:checked:checked~.option-1 span,
        #option-2:checked:checked~.option-2 span {
            color: #fff;
        }

    </style>

@endpush


@push('script')
    <script>
        "use strict";

       
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    "<span class='text-danger'>@changeLang('Captcha field is required.')</span>";
                return false;
            }
            return true;
        }

        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush
