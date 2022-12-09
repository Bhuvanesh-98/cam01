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
                    <h1>@changeLang('All Categories')</h1>
                    <ul>
                        <li><a href="{{route('home')}}">@changeLang('Home')</a></li>
                        <li><span>@changeLang('All Categories')</span></li>
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

    <div class="case-study-home-page case-study-area pt_50 pb_40">
        <div class="container">
            <div class="row">

                @forelse ($categories as $category)

                    <div class="col-lg-4 col-md-6 mt_15">
                        <div class="case-item">
                            <div class="case-box">
                                <div class="case-image">
                                    <img src="{{ getFile('category' , $category->image) }}" alt="">
                                    <div class="overlay"><a
                                            href="{{ route('category.details', Str::slug($category->name)) }}"
                                            class="btn-case">@changeLang('View All Experts')</a>
                                    </div>
                                </div>
                                <div class="case-content">
                                    <h4><a
                                            href="{{ route('category.details', Str::slug($category->name)) }}">{{ __($category->name) }}</a>
                                    </h4>
                                </div>
                            </div>
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

                <div class="col-md-12 my-5">

                    {{ $categories->links('frontend.partials.paginate') }}

                </div>


            </div>
        </div>



    @endsection
