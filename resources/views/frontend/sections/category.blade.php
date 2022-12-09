@php

    $content = content('category.content');

    $categories = App\Models\Category::whereHas('services',function($q){$q->where('status',1);})->whereHas('services.user')->where('status',1)->latest()->take(6)->get();

@endphp
<!--Portfolio Start-->
<div class="case-study-home-page case-study-area pt_70 pb_20">
    <div class="container">
        <div class="row mb_25">
            <div class="col-md-12 wow fadeInDown" data-wow-delay="0.1s">
                <div class="main-headline">
                    <h1>{{__(@$content->data->title)}}</h1>
                    <p>{{__(@$content->data->sub_title)}}</p>
                </div>
            </div>
        </div>
        <div class="row">

        @foreach ($categories as $category)
            <div class="col-lg-4 col-md-6">
                <div class="case-item">
                    <div class="case-box">
                        <div class="case-image">
                            <img src="{{getFile('category',$category->image)}}" alt="">
                            <div class="overlay"><a href="{{route('category.details',Str::slug($category->name))}}" class="btn-case">@changeLang('See Details')</a>
                            </div>
                        </div>
                        <div class="case-content">
                            <h4><a href="{{route('category.details',Str::slug($category->name))}}">{{__($category->name)}}</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
            
        </div>
        <div class="row mb_60">
            <div class="col-md-12">
                <div class="home-button">
                    <a href="{{route('category.all')}}">{{changeDynamic(@$content->data->button_text)}}</a>
                </div>
            </div>
        </div>
    </div>
</div>