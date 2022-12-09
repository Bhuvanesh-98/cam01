@extends('frontend.layout.frontend')
@section('breadcumb')

@php

    $content = content('breadcrumb.content');

@endphp
<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{getFile('breadcrumb', @$content->data->image)}});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>@changeLang('Expert details')</h1>
                    <ul>
                        <li><a href="{{route('home')}}">@changeLang('Home')</a></li>
                        <li><span>@changeLang('Expert details')</span></li>
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

    <!--Team Detail Start-->
    <div class="team-detail-page pt_40 pb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="team-detail-photo">
                        <img src="@if ($user->image) {{ getFile('user', $user->image) }} @else {{ getFile('logo', $general->default_image) }} @endif" alt="Team Photo">
                    </div>
                    @if ($user->social)
                        <div class="team-detail-social">
                            <ul>
                                @if ($user->social->facebook)
                                    <li><a href="{{ $user->social->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                @endif
                                @if ($user->social->twitter)
                                    <li><a href="{{ $user->social->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                @endif
                                @if ($user->social->youtube)
                                    <li><a href="{{ $user->social->youtube }}"><i class="fab fa-youtube"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col-lg-8">
                    <div class="team-detail-text">
                        <h4>{{ __($user->fullname) }}</h4>
                        <span><b>{{ $user->designation }}</b></span>
                        <div class="star-items mt_10">
                            @for ($i = 0; $i < number_format($rating); $i++)
                                <i class="fas fa-star"></i>
                            @endfor

                        </div>
                        <div class="total-job mt_10">
                            {{ $jobSuccess }} @changeLang('Successful Jobs')
                        </div>
                        <p>
                            @php
                                
                                echo clean($user->details);
                            @endphp
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($services->count() > 0)
        <div class="expert-sevice bg_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>@changeLang('All Offered Services')</h2>
                    </div>
                </div>
                <div class="row">
                    @foreach ($services as $service)

                        <div class="col-md-4">
                            <div class="service-list">
                                <div class="photo">
                                    <a
                                        href="{{ route('service.details', ['id' => $service->id, 'slug' => Str::slug($service->name)]) }}"><img
                                            src="
                                         @if($service->service_image) {{getFile('service',$service->service_image)}} @else {{getFile('logo',$general->service_default_image)}} @endif
                    " alt=""></a>
                    <div class="cat">
                        {{ __($service->category->name) }}
                    </div>
                </div>
                <div class="title"><a
                        href="{{ route('service.details', ['id' => $service->id, 'slug' => Str::slug($service->name)]) }}">{{ $service->name }}</a>
                </div>
                <div class="rate">{{ $general->currency_icon . '' . $service->rate }}</div>
                <div class="rating">
                    <div class="star-items">
                        @for ($i = 0; $i < number_format($service->reviews()->avg('review')); $i++)
                            <i class="fas fa-star"></i>
                        @endfor

                    </div>
                </div>
            </div>
        </div>
    @endforeach

    </div>
    </div>
    </div>
    @endif

    <div class="team-exp-area pt_70 pb_70">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="team-headline">
                        <h2>@changeLang('Profile Details')</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <!--Tab Start-->
                    <div class="event-detail-tab mt_20">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a class="active" href="#working_hour" data-toggle="tab">@changeLang('Working Hours')</a>
                            </li>
                            <li>
                                <a href="#service_location" data-toggle="tab">@changeLang('Service Locations')</a>
                            </li>
                            <li>
                                <a href="#experience" data-toggle="tab">@changeLang('Experience')</a>
                            </li>
                            <li>
                                <a href="#qualification" data-toggle="tab">@changeLang('Qualifications')</a>
                            </li>
                            <li>
                                <a href="#contact" data-toggle="tab">@changeLang('Contact')</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content event-detail-content">
                        <div id="working_hour" class="tab-pane fade show active">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="wh-table table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>@changeLang('Week Day')</th>
                                                    <th>@changeLang('Availability')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($workingHour as $key => $schedule)

                                                    <tr>
                                                        <td>{{ __($key) }}</td>
                                                        <td>
                                                            @foreach ($schedule as $sch)

                                                                <div class="sch">
                                                                    {{ \Carbon\Carbon::parse($sch->start_time)->format('h:i A') . '-' . \Carbon\Carbon::parse($sch->end_time)->format('h:i A') }}
                                                                </div>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="service_location" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="wh-table table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>@changeLang('Service')</th>
                                                    <th>@changeLang('Location')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($services as $service)

                                                    <tr>
                                                        <td>{{ __($service->name) }}</td>
                                                        <td>
                                                            {{ __(str_replace(['.', '"'], [',', ''], $service->location)) }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="experience" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>@php
                                        echo clean($user->experience);
                                    @endphp</p>
                                </div>
                            </div>
                        </div>
                        <div id="qualification" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        @php
                                            
                                            echo clean($user->qualification);
                                        @endphp
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div id="contact" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="item d-flex align-items-center justify-content-center">
                                        <div class="item-content">
                                            <h3>@changeLang('Contact Address')</h3>
                                            <p>
                                                {{ @$user->address->address ??  @$user->address->city.','.@$user->address->zip.','.@$user->address->country}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="item d-flex align-items-center justify-content-center">
                                        <div class="item-content">
                                            <h3>@changeLang('Phone')</h3>
                                            <p>
                                                {{ $user->mobile }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="item d-flex align-items-center justify-content-center">
                                        <div class="item-content">
                                            <h3>@changeLang('Email Address')</h3>
                                            <p>
                                                {{ $user->email }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Tab End-->
                </div>

            </div>
        </div>
    </div>
    <!--Team Detail End-->



@endsection
