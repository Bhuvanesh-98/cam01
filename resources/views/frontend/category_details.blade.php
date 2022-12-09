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
                    <h1>@changeLang('Category Services')</h1>
                    <ul>
                        <li><a href="{{route('home')}}">@changeLang('Home')</a></li>
                        <li><span>@changeLang('Category Services')</span></li>
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
        <meta name='description' content="{{$general->seo_description}}">
@endpush

<div class="expert-sevice bg_area pt_30 pb_60">
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
@endsection