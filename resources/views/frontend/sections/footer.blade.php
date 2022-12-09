@php
    $footer = content('footer.content');

    $about = content('about.content');

    $categories = App\Models\Category::where('status',1)->latest()->take(4)->get();

    $policies = element('policy.element');

    $contact = content('contact.content');

    $socials = element('social.element');
   
@endphp

<!--Footer Start-->
<div class="main-footer">
   
    <div class="footer-area" style="background-image: url({{getFile('footer',@$footer->data->image)}})">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="footer-item">
                        <h3>{{$navbar['About Us']}}</h3>
                        <div class="textwidget">
                            <p>
                                {{@$footer->data->short_description}}
                            </p>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-item">
                        <h3>{{$navbar['Categories']}}</h3>
                        <ul>
                          @foreach ($categories as $category)
                            <li><a href="{{route('category.details',Str::slug($category->name))}}">{{__($category->name)}}</a></li>
                          @endforeach
                            
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-item">
                        <h3>{{$navbar['Quick Links']}}</h3>
                        <ul>
                            <li><a href="{{route('home')}}">{{$navbar['Home']}}</a></li>
                            @foreach ($policies as $policy)
                                <li><a href="{{route('policy', @$policy->data->slug)}}">{{__(@$policy->data->page_name)}}</a></li>
                            @endforeach
                            
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-item">
                        <h3>{{$navbar['Contact Info']}}</h3>
                        <ul>
                            <li><b>{{$navbar['Address']}}:</b> <br>{{__(@$contact->data->address)}}</li>
                            <li><b>{{$navbar['Call']}}:</b> <br>{{__(@$contact->data->phone)}}</li>
                            <li><b>{{$navbar['Email']}}:</b> <br>{{__(@$contact->data->email)}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyrignt">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="copyright-text">
                        <p>{{__(@$footer->data->copyright)}}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer-social">
                        @foreach ($socials as $social )
                            <a href="{{@$social->data->socail_link}}"><i class="{{@$social->data->social_icon}}"></i></a>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Footer End-->

<!--Scroll-Top-->
<div class="scroll-top">
    <i class="fa fa-angle-up"></i>
</div>
<!--Scroll-Top-->
