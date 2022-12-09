@php
    $content = content('counter.content');
    $element = element('counter.element',4);
@endphp


<div class="counter-section" style="background-image: url({{getFile('counter',@$content->data->backgroud)}})">
    <div class="container">
        <!--Counter Start-->
        <div class="row">
        @foreach ($element as $counter)
            
            <div class="col-lg-3 col-6 wow fadeInDown" data-wow-delay="0.2s">
                <div class="counter-item">
                    <div class="counter-icon">
                        <i class="{{@$counter->data->icon}}"></i>
                    </div>
                    <h2 class="counter">{{__(@$counter->data->counter)}}</h2>
                    <h4>{{__(@$counter->data->title)}}</h4>
                </div>
            </div>
        @endforeach
            
        </div>
        <!--Counter End-->
    </div>
</div>
