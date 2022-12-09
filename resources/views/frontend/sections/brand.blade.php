@php

    $element = element('brand.element');

@endphp

<!--Brand-Area Start-->
<div class="brand-area bg-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="brand-carousel owl-carousel">
                    @foreach ($element as $brand)    
                    <div class="brand-item">
                        <div class="brand-colume">
                            <div class="brand-bg"></div>
                            <img src="{{getFile('brand',$brand->data->image)}}" alt="Brand">
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!--Brand-Area End-->