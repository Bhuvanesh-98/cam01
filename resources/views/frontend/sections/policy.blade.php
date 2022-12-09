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
                    <h1>{{changeDynamic($pageTitle)}}</h1>
                    <ul>
                        <li><a href="{{route('home')}}">@changeLang('Home')</a></li>
                        <li><span>{{changeDynamic($pageTitle)}}</span></li>
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
        <meta name='title' Content="{{ $general->seo_title }}">
        <meta name='description' content="{{ $general->seo_description }}">
    @endpush



<div class="about-style1 pt_50 pb_50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>
                   @php
                       echo clean($policy->data->details);
                   @endphp
                </p>
                
            </div>
        </div>
    </div>
</div>




@endsection