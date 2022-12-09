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
                    <h1>@changeLang('Experts')</h1>
                    <ul>
                        <li><a href="{{route('home')}}">@changeLang('Home')</a></li>
                        <li><span>@changeLang('Experts')</span></li>
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
        <meta name='description' content="{{@$general->seo_description}}">
@endpush


    <!--Service Start-->
    <div class="team-page pt_30 pb_60">
        <div class="container">
            <div class="row justify-content-center">

                @forelse ($experts as $expert)
                    <div class="col-lg-3 col-md-4 col-12 mt_30">
                        <div class="team-item">
                            <div class="team-photo">
                                <img src="@if($expert->image) {{getFile('user',$expert->image)}} @else {{getFile('logo',$general->default_image)}} @endif" alt="Team Photo">
                            </div>
                            <div class="team-text">
                                <a
                                    href="{{ route('service.provider.details', $expert->slug) }}">{{ __(ucwords($expert->fullname)) }}</a>
                                <p>{{ $expert->designation }}</p>
                            </div>
                            @if($expert->social)
                            <div class="team-social">
                                <ul>
                                    @if($expert->social->facebook)
                                    <li><a href="{{$expert->social->facebook}}"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif
                                     @if($expert->social->twitter)
                                    <li><a href="{{$expert->social->twitter}}"><i class="fab fa-twitter"></i></a></li>
                                    @endif
                                    @if($expert->social->youtube)
                                    <li><a href="{{$expert->social->youtube}}"><i class="fab fa-youtube"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                @empty

                            <div class="col-12 col-md-6 col-sm-12">
                                <div class="card">
                                    
                                    <div class="card-body">
                                        <div class="empty-state" data-height="400">
                                            <div class="empty-state-icon">
                                                <i class="far fa-sad-tear"></i>
                                            </div>
                                            <h2>@changeLang('Sorry We could not find any data')</h2>
                                           
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
              

                @endforelse

            </div>
        </div>
    </div>
    <!--Service End-->

@endsection


@push('custom-css')

    <style>
        .empty-state {
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 40px;
        }

        .empty-state .empty-state-icon {
            position: relative;
            background-color: #ca9520;
            width: 80px;
            height: 80px;
            line-height: 100px;
            border-radius: 5px;
        }

        .empty-state .empty-state-icon i {
            font-size: 40px;
            color: #fff;
            position: relative;
            z-index: 1;
        }

        .empty-state h2 {
            font-size: 20px;
            margin-top: 30px;
        }

        .empty-state p {
            font-size: 16px;
        }

    </style>

@endpush
