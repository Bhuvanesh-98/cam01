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
        <meta name='description' content="{{ @$general->seo_description }}">
    @endpush

      <div class="blog-page pt_40 pb_90">
        <div class="container">

            <div class="row justify-content-center">
                @forelse ($blogs as $blog)
                    <div class="col-lg-4 col-sm-6">



                        <div class="blog-item">

                            <div class="blog-image">
                                <img src="{{ getFile('blog' , @$blog->data->image) }}" alt="">
                            </div>

                            <div class="blog-author">
                                <span><i class="fas fa-user"></i> Admin</span>
                                <span><i class="fas fa-calendar"></i> {{ $blog->created_at->format('d-m-Y') }}</span>
                            </div>
                            <div class="blog-text">
                                <h3><a
                                        href="{{ route('blog.details',Str::slug(@$blog->data->heading)) }}">{{ __(@$blog->data->heading) }}</a>
                                </h3>
                                <div class="line-clamp">
                                <p>
                                    {{ __(@$blog->data->short_description)}}
                                    
                                </p>
                                </div>
                                <a class="sm_btn" href="{{ route('blog.details', Str::slug(@$blog->data->heading)) }}">
                                @changeLang('Learn more')→</a>
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
                                            <h2>@changeLang('Sorry We couldn\'t find any data')</h2>
                                           
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                @endforelse

            </div>
                {{$blogs->links('frontend.partials.paginate')}}
        </div>
    </div>



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