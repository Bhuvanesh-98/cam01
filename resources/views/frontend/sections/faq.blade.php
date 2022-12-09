@php

$faqchunk = App\Models\FaqCategory::whereHas('faqs')->get();

@endphp


<!--Faq Start-->
<div class="faq-area pt_20 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="faq-service feature-section-text mt_30">
                @foreach ($faqchunk as  $faq)
                    
                    <h2 class="mt_30 mb_0">{{__($faq->name)}}</h2>
                    <div class="feature-accordion mt_10" id="accordion-{{$faq->id}}">
                    @foreach ($faq->faqs as $fa)
                        <div class="faq-item card">
                            <div class="faq-header" id="heading{{$fa->id}}">
                                <button class="faq-button {{$loop->parent->first && $loop->first ? '' :'collapsed'}} " data-toggle="collapse" data-target="#collapse{{$fa->id}}" aria-expanded="true" aria-controls="collapse{{$fa->id}}">{{__(@$fa->data->question)}}</button>
                            </div>

                            <div id="collapse{{$fa->id}}" class="collapse {{$loop->parent->first && $loop->first ? 'show' :''}}" aria-labelledby="heading{{$fa->id}}" data-parent="#accordion-{{$faq->id}}">
                                <div class="faq-body">
                                    @php echo clean(__(@$fa->data->answer)) @endphp
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!--Faq End-->