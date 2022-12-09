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
                    <h1>@changeLang('Service Details')</h1>
                    <ul>
                        <li><a href="{{route('home')}}">@changeLang('Home')</a></li>
                        <li><span>@changeLang('Service Details')</span></li>
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
        <meta name='description' content="{{ $general->seo_description }}">
    @endpush


    <!--Service Detail Start-->
    <div class="service-detail-area pt_40">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="service-detail-text pt_30">

                        @if ($service->gallery)

                            <div class="row mb_30">
                                <div class="col-md-12">
                                    <!-- Swiper -->
                                    <div class="swiper-container pro-detail-top">
                                        <div class="swiper-wrapper">
                                            @foreach (json_decode($service->gallery) as $gallery)

                                                <div class="swiper-slide">
                                                    <div class="catagory-item">
                                                        <div class="catagory-img-holder">
                                                            <img src="{{ getFile('service', $gallery) }}" alt="">
                                                            <div class="catagory-text">
                                                                <div class="catagory-text-table">
                                                                    <div class="catagory-text-cell">
                                                                        <ul class="catagory-hover">
                                                                            <li><a href="{{ getFile('service', $gallery) }}"
                                                                                    class="magnific"><i
                                                                                        class="fas fa-search"></i></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                        <!-- Add Arrows -->
                                        <div class="swiper-button-next swiper-button-white"></div>
                                        <div class="swiper-button-prev swiper-button-white"></div>
                                    </div>
                                    <div class="swiper-container pro-detail-thumbs">
                                        <div class="swiper-wrapper">
                                            @foreach (json_decode($service->gallery) as $gallery)
                                                <div class="swiper-slide"><img src="{{ getFile('service', $gallery) }}"
                                                        alt=""></div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <p>@php
                            echo __($service->details);
                        @endphp</p>
                    </div>
                    @if ($service->faq)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="faq-service feature-section-text mt_50">
                                    <h2>@changeLang('Frequently Asked Questions')</h2>
                                    <div class="feature-accordion" id="accordion">
                                        @foreach ($service->faq as $faq)

                                            <div class="faq-item card">
                                                <div class="faq-header" id="heading{{ $loop->iteration }}">
                                                    <button class="faq-button {{ $loop->first ? '' : 'collapsed' }} "
                                                        data-toggle="collapse"
                                                        data-target="#collapse{{ $loop->iteration }}" aria-expanded="true"
                                                        aria-controls="collapse{{ $loop->iteration }}">{{ __($faq['question']) }}</button>
                                                </div>

                                                <div id="collapse{{ $loop->iteration }}"
                                                    class="collapse {{ $loop->first ? 'show' : '' }}"
                                                    aria-labelledby="heading{{ $loop->iteration }}"
                                                    data-parent="#accordion">
                                                    <div class="faq-body">
                                                        {{ __($faq['answer']) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    @if ($service->video[0] != null)
                        <div class="row mt_50">
                            <div class="col-12">
                                <div class="video-headline">
                                    <h3>@changeLang('Releted Videos')</h3>
                                </div>
                            </div>
                            @foreach ($service->video as $video)

                                <div class="col-md-6">
                                    <div class="video-item mt_30">
                                        <div class="video-img">
                                            <img src="http://img.youtube.com/vi/{{ $video }}/maxresdefault.jpg"
                                                alt="">
                                            <div class="video-section">
                                                <a class="video-button mgVideo"
                                                    href="https://www.youtube.com/watch?v={{ $video }}"><span></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endif
                  
                   
                    <div class="row mt_50">
                        <div class="col-md-12" id="review">
                            <div class="comment-list mt_30">
                             @if($service->reviews->count() > 0)
                                <h4>@changeLang('Reviews') <span class="c-number">({{ $service->reviews_count }})</span>
                                </h4>
                            @endif
                                <ul>
                                    @foreach ($service->reviews as $review)
                                        @if($review->status)
                                        <li>
                                            <div class="comment-item">
                                                <div class="thumb">
                                                    <img src="@if($review->user->image) {{getFile('user',$review->user->image)}} @else {{getFile('logo',$general->default_image)}}@endif"
                                                        alt="">
                                                </div>
                                                <div class="com-text">
                                                    <h5>{{ @$review->user->fullname }}</h5>
                                                    <span class="date"><i class="fa fa-calendar"></i>
                                                        {{ $review->created_at->format('d F Y') }}</span>
                                                    <div class="star-items mt_10">
                                                        @for ($i = 0; $i < $review->review; $i++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor

                                                    </div>
                                                    <p>
                                                        {{ __($review->review_message) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                    @endforeach

                                </ul>
                            </div>

                            @auth
                                <div class="comment-form mt_30">
                                    <h4>@changeLang('Write A Review')</h4>
                                    <form action="{{ route('review', $service->id) }}" method="post">
                                        @csrf
                                        <div class="form-row row">
                                            <div class="form-group col-md-12">
                                                <select name="review" class="form-control">
                                                    <option value="">@changeLang('Select Rating')</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12">
                                                <textarea class="form-control" name="review_comment"></textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <button type="submit" class="btn">@changeLang('Submit')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endauth
                        </div>
                    </div>
                   



                </div>
                <div class="col-md-4">
                    <div class="service-sidebar pt_30">

                        <div class="booking-widget">
                            <div class="price">
                                <div class="amount">
                                    {{ $general->currency_icon . '' . $service->rate}}</span>
                                </div>
                                <div class="type">
                                    @switch($service->duration)
                                        @case(0)
                                            @changeLang('Hourly')
                                        @break
                                        @case(1)
                                            @changeLang('Daily')
                                        @break
                                        @case(2)
                                            @changeLang('Weekly')
                                        @break

                                        @case(3)
                                            @changeLang('Monthly')
                                        @break

                                        @case(4)
                                            @changeLang('Yearly')
                                        @break

                                        @default
                                            @changeLang('Fixed')

                                    @endswitch
                                </div>
                                <div class="star-items mt_10">
                                    @for ($i = 0; $i < number_format($service->reviews()->avg('review')); $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                            </div>

                            <div class="book">

                                @auth
                                    @if (auth()->user()->user_type == 1)
                                        <a href="" data-toggle="modal" data-target="#modal_book">@changeLang('Book Now')</a>
                                    @endif
                                    <a href="#review" class="write_review mt_10">@changeLang('Write A Review')</a>


                                    <!-- Modal -->
                                    <div class="modal fade" id="modal_book" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">@changeLang('Book Now')</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('user.booking', $service) }}">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="">@changeLang('Start Date')</label>
                                                            <input type="text" name="date" class="form-control start_date"
                                                                autocomplete="off">
                                                        </div>
                                                        @if($service->duration == 1)
                                                        <div class="form-group">
                                                            <label for="">@changeLang('End Date')</label>
                                                            <input type="text" name="end_date" class="form-control end_date" autocomplete="off">
                                                        </div>
                                                        @endif
                                                        @if ($service->duration == 0)
                                                            <div class="form-group">
                                                                <label for="">@changeLang('How Many Hours')</label>
                                                                <input type="number" name="hours" class="form-control" min="0">
                                                            </div>
                                                        @endif
                                                        <div class="form-group">
                                                            <label for="">@changeLang('Start Time')</label>
                                                            <input type="text" name="time" class="form-control timepicker"
                                                                autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">@changeLang('Location')</label>
                                                            <select name="location" id="" class="form-control">
                                                            

                                                                @foreach (explode(',', (str_replace(['.','"'],[',',''],$service->location))) as $location)
                                                                    <option value="{{ $location }}">{{ $location }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">@changeLang('Message')</label>
                                                            <textarea name="message" class="form-control" cols="30"
                                                                rows="10"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-base">@changeLang('Book Now')</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                @else

                                    <a href="{{ route('user.login') }}">@changeLang('Login For Bookings')</a>

                                @endauth


                            </div>
                        </div>

                        <div class="provider-widget">
                            <h2>@changeLang('Service Provider')</h2>
                            <div class="photo">
                                <img src="@if($service->user->image) {{getFile('user',$service->user->image)}} @else {{getFile('logo',$general->default_image)}} @endif" alt="">
                            </div>
                            <div class="name">
                                <a href="{{route('service.provider.details',Str::slug($service->user->username))}}">{{ $service->user->fullname }}</a>
                            </div>
                        </div>

                        <div class="service-widget-contact mt_30">
                            <h2>@changeLang('Contact Info')</h2>
                            <ul>
                                <li><i class="fas fa-phone"></i> {{ $service->user->mobile }}</li>
                                <li><i class="far fa-envelope"></i> {{ $service->user->email }}</li>
                                <li><i class="fas fa-map-marker-alt"></i>
                                    {{ @$service->user->address->address . ' ' . @$service->user->address->city . ' ' . @$service->user->address->country }}
                                </li>
                            </ul>
                        </div>
                        <div class="service-qucikcontact event-form mt_30">
                            <h3>@changeLang('Contact Provider')</h3>
                            <form method="post" action="{{ route('send.provider.email', $service->user->id) }}">
                                @csrf
                                <div class="form-row row">
                                    <div class="form-group col-md-12">
                                        <label for="">@changeLang('Name')</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">@changeLang('Email')</label>
                                        <input type="text" name="email" class="form-control">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="">@changeLang('Subject')</label>
                                        <input type="text" name="subject" class="form-control">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="">@changeLang('Message')</label>
                                        <textarea class="form-control" name="message"></textarea>
                                    </div>

                                    @if (@$general->allow_recaptcha)

                                    <div class="col-md-12 my-3">
                                    
                                    <script src="https://www.google.com/recaptcha/api.js"></script>
                                    <div class="g-recaptcha" data-sitekey="{{ @$general->recaptcha_key }}"
                                        data-callback="verifyCaptcha"></div>
                                    <div id="g-recaptcha-error"></div>
                                    </div>

                                @endif

                                    <div class="form-group col-md-12">
                                        <button type="submit" id="recaptcha" class="btn">@changeLang('Send Message')</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!--Service Detail End-->



@endsection

@push('script')

    <script>
        $(function() {
            'use strict'
            $('.timepicker').timepicker({
                timeFormat: 'h:mm p',
                interval: 30,
                scrollbar: true
            });

            $(".start_date").datepicker({
              minDate: 0,
              onSelect: function(date) {
                $(".end_date").datepicker('option', 'minDate', date);
              }
            });

            $('.end_date').datepicker( {
                /*onSelect: function(date) {
                    let start_date = new Date($('input[name="date"]').val());
                    let end_date = new Date(date);
                    let diffTime = Math.abs(end_date - start_date);
                    let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                    let old_rate = {{$service->rate}};
                    let new_rate = old_rate * diffDays;
                    $('.rate').text(new_rate.toFixed(2));
                },*/
            });
        })


    </script>

@endpush

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = "<span class='text-danger'>@changeLang('Captcha field is required.')</span>";
                return false;
            }
            return true;
        }
        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush


@push('custom-css')

    <style>
        .ui-timepicker-standard {
            z-index: 9999 !important;
        }

        .ui-datepicker {
            top: 183px !important;
        }

    </style>


@endpush
