@php

    $content = content('testimonial.content');

    $element = element('testimonial.element');

@endphp

<!--Testimonial Start-->
<div class="testimonial-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-headline">
                    <h1>{{__(@$content->data->title)}}</h1>
                    <p>{{__(@$content->data->sub_heading)}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="testimonial-texarea mt_30">
                    <div class="owl-testimonial owl-carousel">
                    @foreach ($element as  $client)
                        
                        <div class="testimonial-item wow fadeIn" data-wow-delay="0.2s" style="background-image: url({{getFile('testimonial',@$content->data->image)}})">
                            <p class="wow fadeInDown" data-wow-delay="0.2s">
                                {{__(@$client->data->quote)}}
                            </p>
                            <div class="testi-info wow fadeInUp" data-wow-delay="0.2s">
                                <img src="{{getFile('testimonial', @$client->data->client_image)}}" alt="">
                                <h4>{{__(@$client->data->name)}}</h4>
                                <span>{{__(@$client->data->designation)}}</span>
                            </div>
                        </div>
                    @endforeach
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Testimonial End-->