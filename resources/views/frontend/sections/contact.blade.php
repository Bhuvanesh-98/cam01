
@php

    $content = content('breadcrumb.content');

@endphp


    <!--Form Start-->
    <div class="contauct-style1  pt_50 pb_65">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="about1-text mt_30">
                        <h1>{{ __(@$contact->data->title) }}</h1>
                        <p class="mb_30">
                            {{ __(@$contact->data->sub_title) }}
                        </p>
                    </div>
                    <form method="post" action="{{route('contact')}}">
                        @csrf
                        <div class="row contact-form">
                            <div class="col-lg-6 form-group">
                                <label>@changeLang('Name') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"  name="name">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label>@changeLang('Email Address') <span class="text-danger">*</span></label>
                                <input type="text"  class="form-control" name="email">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label>@changeLang('Phone')<span class="text-danger">*</span></label>
                                <input type="text"  class="form-control" name="phone">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label>@changeLang('Subject') <span class="text-danger">*</span></label>
                                <input type="text"  class="form-control" name="subject">
                            </div>
                            <div class="col-lg-12 form-group">
                                <label>@changeLang('Message') <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control" id="massege"></textarea>
                            </div>


                            @if (@$general->allow_recaptcha)

                                <div class="col-md-12 my-3">

                                    <script src="https://www.google.com/recaptcha/api.js"></script>
                                    <div class="g-recaptcha" data-sitekey="{{ @$general->recaptcha_key }}"
                                        data-callback="verifyCaptcha"></div>
                                    <div id="g-recaptcha-error"></div>
                                </div>

                            @endif
                            <div class="col-md-12 form-group">
                                <button type="submit" id="recaptcha" class="btn">{{ changeDynamic(@$contact->data->button_text) }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-5">
                    <div class="contact-info-item bg1 mb_30 mt_30">
                        <div class="contact-info">
                            <span>
                                <i class="fas fa-phone"></i> @changeLang('Phone'):
                            </span>
                            <div class="contact-text">
                                <p>
                                    {{ @$contact->data->phone }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="contact-info-item bg2 mb_30">
                        <div class="contact-info">
                            <span>
                                <i class="far fa-envelope"></i> @changeLang('Email'):
                            </span>
                            <div class="contact-text">
                                <p>
                                    {{ @$contact->data->email }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="contact-info-item bg3 mb_30">
                        <div class="contact-info">
                            <span>
                                <i class="fas fa-map-marker-alt"></i> @changeLang('Address'):
                            </span>
                            <div class="contact-text">
                                <p>
                                    {{ @$contact->data->address }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Form End-->

    <!--Google map start-->
    <div class="map-area">
        <iframe
            src="{{clean(@$contact->data->map_link)}}"
            frameborder="0"  allowfullscreen="" aria-hidden="false"
            tabindex="0"></iframe>
    </div>
    <!--Google map end-->




@push('custom-css')
<style>

    .map-area iframe{
        width:100% !important;
        height:550px !important;
        border:0
    }

</style>
    
@endpush

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">Captcha field is required.</span>';
                return false;
            }
            return true;
        }
        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush
