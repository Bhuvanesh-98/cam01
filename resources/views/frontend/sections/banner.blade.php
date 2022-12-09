@php

$content = content('banner.content');

$categories = App\Models\Category::where('status', 1)
    ->orderBy('name','ASC')
    ->take(6)
    ->get();
@endphp

<!--Slider Start-->
<div class="slider" id="main-slider">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="doc-search-item">
                    <div class="d-flex align-items-center h-100">
                        <div class="v-mid-content">
                            <div class="heading">
                                <h2>{{ __(@$content->data->title) }}</h2>
                                <p>{{ __(@$content->data->sub_title) }}</p>
                            </div>
                            <div class="doc-search-section">
                                <form action="{{route('experts.search')}}" method="get">
                                    <div class="box box-search">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="@changeLang('Search by expert name')">
                                    </div>
                                    <div class="box">
                                        <select class="form-control select2" name="category">
                                            <option value="">@changeLang('Search Category')</option>
                                            @foreach ($categories as $category)
                                                <option>{{ __($category->name) }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="doc-search-button">
                                        <button type="submit" class="btn btn-danger"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <img src="@if(@$content->data->image){{ getFile('banner', @$content->data->image) }} @else {{getFile('logo', @$general->default_image)}} @endif" alt="">
            </div>
        </div>
    </div>

</div>
<!--Slider End-->
