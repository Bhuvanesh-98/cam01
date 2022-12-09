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
                    <h1>@changeLang('All Blogs')</h1>
                    <ul>
                        <li><a href="{{route('home')}}">@changeLang('Home')</a></li>
                        <li><span>@changeLang('All Blogs')</span></li>
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


    <div class="blog-page pt_40 pb_90">
        <div class="container">

            <div class="row">
                @foreach ($blogs as $blog)
                    <div class="col-lg-4 col-sm-6">



                        <div class="blog-item">

                            <div class="blog-image">
                                <img src="{{ getFile('blog' , @$blog->data->image) }}" alt="">
                            </div>

                            <div class="blog-author">
                                <span><i class="fas fa-user"></i>Admin</span>
                                <span><i class="fas fa-calendar"></i> {{ $blog->created_at->format('d-m-Y') }}</span>
                            </div>
                            <div class="blog-text">
                                <h3><a
                                        href="{{ route('blog.details', Str::slug(@$blog->data->heading)) }}">{{ __(@$blog->data->heading) }}</a>
                                </h3>
                                <p>
                                   {{@$blog->data->short_description}}
                                </p>
                                <a class="sm_btn" href="{{ route('blog.details', Str::slug(@$blog->data->heading)) }}">@changeLang('Learn more ')→</a>
                            </div>
                        </div>


                    </div>
                @endforeach

            </div>
                {{$blogs->links('frontend.partials.paginate')}}
        </div>
    </div>


@endsection
