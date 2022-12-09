@php 

    $content = content('about.content');

@endphp
<div class="about-style1 pt_50 pb_50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
               @php
                    echo __(@$content->data->details)
               @endphp
            </div>
        </div>
    </div>
</div>