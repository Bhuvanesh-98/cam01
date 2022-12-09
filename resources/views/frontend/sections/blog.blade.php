@php

    $blogContent = content('blog.content');

    if(request()->routeIs('pages')){
        $blogElement = App\Models\SectionData::where('key', 'blog.element')->latest()->paginate(9);
    }else{
         $blogElement = element('blog.element',6);
    }
        

@endphp

@if($blogElement instanceof \Illuminate\Pagination\LengthAwarePaginator)

<div class="blog-page pt_40 pb_90">
        <div class="container">

            <div class="row justify-content-center">
                @forelse ($blogElement as $blog)
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
                                            <h2>@changeLang('Sorry We could not find any data')</h2>
                                           
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                @endforelse

            </div>
                {{$blogElement->links('frontend.partials.paginate')}}
        </div>
    </div>

@else
<!--Blog-Area Start-->
<div class="blog-area bg_ecf1f8">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-headline">
                    <h1>{{__(@$blogContent->data->heading)}}</h1>
                    <p>{{__(@$blogContent->data->sub_heading)}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="blog-carousel owl-carousel">

                @foreach ($blogElement as $blog)
                    
                    <div class="blog-item effect-item">
                        <a href="{{route('blog.details',Str::slug(@$blog->data->heading))}}" class="image-effect">
                            <div class="blog-image">
                                <img src="@if(@$blog->data->image){{ getFile('blog', @$blog->data->image) }} @else {{getFile('logo', @$general->default_image)}} @endif">
                            </div>
                        </a>
                        <div class="blog-text">
                            <div class="blog-author">
                                <span><i class="fas fa-user"></i> Admin</span>
                                <span><i class="fas fa-calendar"></i> {{$blog->created_at->format('Y m d')}}</span>
                            </div>
                            <h3 class="line">
                            <a href="{{route('blog.details',Str::slug(@$blog->data->heading))}}">{{__(@$blog->data->heading)}}</a>
                            </h3>
                            <div class="line-clamp">
                                <p>
                                {{ __(@$blog->data->short_description)}}
                            </p>
                            </div>
                            <a class="sm_btn" href="{{route('blog.details',Str::slug(@$blog->data->heading))}}">@changeLang('Learn more')→</a>
                        </div>
                    </div>
                @endforeach
                   
                </div>
            </div>
        </div>
    </div>
</div>
<!--Blog-Area End-->
@endif
