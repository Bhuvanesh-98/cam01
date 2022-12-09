@php

$content = content('subscribe.content');

@endphp
<!--Subscribe Start-->
<div class="subscribe-area"
    style="background-image: url({{ getFile('subscribe' , @$content->data->image) }})">
    <div class="container">
        <div class="row ov_hd">
            <div class="col-md-12 wow fadeInDown" data-wow-delay="0.1s">
                <div class="main-headline white">
                    <h1>{{ __(@$content->data->title) }}</h1>
                    <p>{{ __(@$content->data->sub_title) }}</p>
                </div>
            </div>
        </div>
        <div class="row ov_hd">
            <div class="col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="subscribe-form">
                    <form method="post" action="{{ route('subscribe') }}">
                        <input type="email" id="email" placeholder="@changeLang('Put your email here')" >
                        <button type="submit" class="btn-sub"
                            id="subscribe">{{ changeDynamic(@$content->data->button_text) }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Subscribe Start-->

@push('meta')

    <meta name="csrf-token" content="{{ csrf_token() }}">

@endpush
@push('script')

    <script>
        'use strict';


        $(function() {
            $('#subscribe').on('click', function(e) {
                e.preventDefault();
                var email = $('#email').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    method: 'POST',
                    url: "{{ route('subscribe') }}",
                    data: {
                        email: email
                    },
                    success: function(response) {

                        if (response.fails) {
                            iziToast.error({
                                message: response.errorMsg.email,
                                position: "topRight"
                            });
                        }

                        if (response.success) {
                            $('#email').val('');
                            iziToast.success({
                                message: response.successMsg,
                                position: "topRight"
                            });
                        }


                    }
                });
            })
        })
    </script>


@endpush
