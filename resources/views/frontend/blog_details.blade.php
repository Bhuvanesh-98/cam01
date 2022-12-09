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
                    <h1>@changeLang('Blog Details')</h1>
                    <ul>
                        <li><a href="{{route('home')}}">@changeLang('Home')</a></li>
                        <li><span>@changeLang('Blog Details')</span></li>
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
        <meta name='description' content="{{ @$blog->data->seo_description }}">
    @endpush

    <!--Blog Start-->
    <div class="blog-page single-blog pt_40 pb_90">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-item">
                        <div class="single-blog-image">
                            <img src="{{ getFile('blog' , @$blog->data->image) }}" alt="">
                            <div class="blog-author">
                                <span><i class="fas fa-user"></i> Admin</span>
                                <span><i class="fas fa-calendar"></i> {{ $blog->created_at->format('d-m-Y') }}</span>
                                <span><i class="fas fa-tag" aria-hidden="true"></i>
                                    {{ @ucwords($blog->data->tag) }}</span>
                            </div>
                        </div>
                        <div class="blog-text pt_40">
                            <p>
                                @php
                                    echo __(@$blog->data->details);
                                @endphp
                            </p>
                        </div>
                    </div>



                    @auth
                        @if (!$general->blog_comment)

                            <div class="comment-list mt_30">
                                <h4>@changeLang('Comments') <span class="c-number">({{ $blog->blog_comments_count }})</span>
                                </h4>
                                <ul>

                                    @foreach ($blog->blogComments as $comment)
                                        @if ($comment->disabled == 1)
                                            <li>
                                                <div class="comment-item">
                                                    <div class="thumb">
                                                        <img src=" @if (@auth()->user()->image)
                                                        {{ getFile('user', auth()->user()->image) }}
                                                    @else
                                                        {{ getFile('logo', $general->default_image) }}
                                                        @endif" alt="">
                                                    </div>
                                                    <div class="com-text">
                                                        <h5>{{ __($comment->name) }}</h5>
                                                        <span class="date"><i class="fa fa-calendar"></i>
                                                            {{ $comment->created_at->format('d F , Y') }}</span>
                                                        <p>
                                                            {{(clean($comment->comment))}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach

                                </ul>
                            </div>


                            <div class="comment-form mt_30">
                                <h4>@changeLang('Post A Comment')</h4>
                                <form method="post" action="{{ route('blog.comment', ['id' => $blog->id]) }}">
                                    @csrf
                                    <div class="form-row row">
                                        <div class="form-group col-md-12">
                                            <label for="">@changeLang('Name') <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="">@changeLang('Email') <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="">@changeLang('Phone') <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control">
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="">@changeLang('Comment') <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="comment"></textarea>
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
                                            <button type="submit" id="recaptcha" class="btn">
                                            @changeLang('Place A Comment')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else

                            <div class="fb-comments"
                                data-href="https://developers.facebook.com/docs/plugins/comments#configurator" data-width=""
                                data-numposts="5"></div>

                        @endif
                    @endauth


                </div>


                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="sidebar-item">
                            <h3>@changeLang('Categories')</h3>
                            <ul>
                                @foreach ($categories as $category)

                                    <li class="active"><a href="{{ route('blog.category', $category->slug) }}"><i
                                                class="fa fa-chevron-right"></i>{{ $category->name }}</a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="sidebar-item">
                            <h3>@changeLang('Recent Post')</h3>
                            @foreach ($recentPosts as $recentPost)
                                <div class="blog-recent-item">
                                    <div class="blog-recent-photo">
                                        <a href="{{ route('blog.details', Str::slug(@$recentPost->data->heading)) }}"><img
                                                src="{{ getFile('blog' , @$recentPost->data->image) }}"
                                                alt=""></a>
                                    </div>
                                    <div class="blog-recent-text">
                                        <a
                                            href="{{ route('blog.details', Str::slug(@$recentPost->data->heading)) }}">{{ __($recentPost->data->heading) }}</a>
                                        <div class="blog-post-date">{{ __($recentPost->created_at->format('M d, Y')) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <!--Sidebar End-->
                </div>
            </div>
        </div>
    </div>
    <!--Blog End-->


@endsection



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
