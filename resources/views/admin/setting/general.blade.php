@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('General Settings')</h1>
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form action="" method="post" enctype="multipart/form-data">

                        @csrf

                        <div class="row">


                            <div class="form-group col-md-3">
                                <label for="">@changeLang('Site Name')</label>
                                <input type="text" name="sitename" class="form-control form_control"
                                    value="{{ @$general->sitename }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label class="form-control-label font-weight-bold"> @changeLang('Timezone')</label>
                                <select class=" form-control" name="timezone">
                                    @foreach ($timezones as $timezone)
                                        <option value="'{{ @$timezone }}'" @if (config('app.timezone') == $timezone) selected @endif>{{ __($timezone) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">@changeLang('Site Currency')</label>
                                <select name="site_currency" id="site_cur" class="form-control">

                                    @include('admin.partials.currency')

                                </select>

                            </div>

                            <div class="form-group col-md-3">
                                <label for="">@changeLang('Currency Icon')</label>
                                <input type="text" name="currency_icon" class="form-control form_control currency_icon"
                                    value="{{ @$general->currency_icon }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label>@changeLang('Commission for Payments')</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            %
                                        </div>
                                    </div>
                                   <input type="text" name="commission" class="form_control form-control"
                                    value="{{ $general->commission }}">
                                </div>
                            </div>


                            <div class="form-group col-md-3">
                                <label for="">@changeLang('User Registration')</label>
                                <select name="user_reg" id="" class="form-control">
                                    <option value="1" {{ $general->user_reg ? 'selected' : '' }}>@changeLang('Yes')</option>
                                    <option value="0" {{ $general->user_reg ? '' : 'selected' }}>@changeLang('No')</option>

                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">@changeLang('Blog Comment')</label>
                                <select name="blog_comment" id="" class="form-control">
                                    <option value="1" {{ $general->blog_comment ? 'selected' : '' }}>@changeLang('Facebook Comment')</option>
                                    <option value="0" {{ $general->blog_comment ? '' : 'selected' }}>@changeLang('Regular Comment')</option>

                                </select>

                            </div>
                            <div class="app">
                            </div>
                            @if ($general->fb_app_key)
                                <div class="form-group col-md-3 app">


                                    <label for="">@changeLang('Facebook Comment App Key')</label>
                                    <input type="text" name="fb_app_key" class="form_control form-control"
                                        value="{{ $general->fb_app_key }}">

                                </div>
                            @endif



                            <div class="col-md-12">

                                <fieldset>
                                    <legend>@changeLang('Site color setting')</legend>
                                    <div class="row">

                                        <div class="form-group col-md-6">
                                            <label for="" class="d-block">@changeLang('Site Color')</label>
                                            <div id="cp2" class="input-group" title="Using input value">
                                                <input type="text" class="form-control form_control input-lg"
                                                    value="{{ $general->color ?? '#DD0F20FF' }}" name="color" />
                                                <span class="input-group-append">
                                                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="" class="d-block">@changeLang('Site Secondary Color')</label>
                                            <div id="cp3" class="input-group" title="Using input value">
                                                <input type="text" class="form-control form_control input-lg"
                                                    value="{{ $general->secondary_color ?? '#DD0F20FF' }}"
                                                    name="secondary_color" />
                                                <span class="input-group-append">
                                                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                                </span>
                                            </div>
                                        </div>



                                    </div>

                                </fieldset>


                            </div>


                            <div class="col-md-12">

                                <fieldset>
                                    <legend>@changeLang('Logo, Favicon and Default Photo setting')</legend>
                                    <div class="row">


                                        <div class="form-group col-md-3 mb-3">
                                            <label class="col-form-label">@changeLang('Site Logo')</label>

                                            <div id="image-preview" class="image-preview"
                                                style="background-image:url({{ getFile('logo', @$general->logo) }});">
                                                <label for="image-upload" id="image-label">@changeLang('Choose File')</label>
                                                <input type="file" name="logo" id="image-upload" />
                                            </div>

                                        </div>

                                        <div class="form-group col-md-3 mb-3">
                                            <label class="col-form-label">@changeLang('Favicon')</label>

                                            <div id="image-preview-icon" class="image-preview"
                                                style="background-image:url({{ getFile('logo', @$general->icon) }});">
                                                <label for="image-upload-icon" id="image-label-icon">@changeLang('Choose File')</label>
                                                <input type="file" name="icon" id="image-upload-icon" />
                                            </div>

                                        </div>

                                        <div class="form-group col-md-3 mb-3">
                                            <label class="col-form-label">@changeLang('Default Image')</label>

                                            <div id="image-preview-default" class="image-preview"
                                                style="background-image:url({{ getFile('logo', @$general->default_image) }});">
                                                <label for="image-upload-default" id="image-label-default">@changeLang('Choose File')</label>
                                                <input type="file" name="default_image" id="image-upload-default" />
                                            </div>

                                        </div> 
                                        
                                        <div class="form-group col-md-3 mb-3">
                                            <label class="col-form-label">@changeLang('Service Default Image')</label>

                                            <div id="image-preview-service-default" class="image-preview"
                                                style="background-image:url({{ getFile('logo', @$general->service_default_image) }});">
                                                <label for="image-upload-service-default" id="image-label-service-default">@changeLang('Choose File')</label>
                                                <input type="file" name="service_default_image" id="image-upload-service-default" />
                                            </div>

                                        </div>



                                    </div>

                                </fieldset>


                            </div>







                            <div class="form-group col-md-12">

                                <button type="submit" class="btn btn-primary">@changeLang('Update General Setting')</button>

                            </div>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection

@push('custom-script')

    <script>
        $(function() {
            'use strict'

            var site_currency = "{{ $general->site_currency }}";

            $('#site_cur option').each(function() {
                if ($(this).val() == site_currency) {
                    $(this).attr('selected', 'selected')
                }
            })

            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "{{changeDynamic('Choose File')}}", // Default: Choose File
                label_selected: "{{changeDynamic('Update Image')}}", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });

            $.uploadPreview({
                input_field: "#image-upload-icon", // Default: .image-upload
                preview_box: "#image-preview-icon", // Default: .image-preview
                label_field: "#image-label-icon", // Default: .image-label
               label_default: "{{changeDynamic('Choose File')}}", // Default: Choose File
                label_selected: "{{changeDynamic('Update Image')}}", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });

            $.uploadPreview({
                input_field: "#image-upload-default", // Default: .image-upload
                preview_box: "#image-preview-default", // Default: .image-preview
                label_field: "#image-label-default", // Default: .image-label
               label_default: "{{changeDynamic('Choose File')}}", // Default: Choose File
                label_selected: "{{changeDynamic('Update Image')}}", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });
            
            $.uploadPreview({
                input_field: "#image-upload-service-default", // Default: .image-upload
                preview_box: "#image-preview-service-default", // Default: .image-preview
                label_field: "#image-label-service-default", // Default: .image-label
                 label_default: "{{changeDynamic('Choose File')}}", // Default: Choose File
                label_selected: "{{changeDynamic('Update Image')}}", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });


            $('#cp2').colorpicker();
            $('#cp3').colorpicker();



            $('select[name=blog_comment]').on('change', function() {
                if ($(this).val() == 1) {
                    var html = `
                    
                             <label for="">@changeLang('Facebook Comment App Key')</label>
                                    <input type="text" name="fb_app_key"  class="form_control form-control" value="{{ $general->fb_app_key }}">
                    
                    `;

                    $('.app').html(html)
                } else {
                    $('.app').html('')
                }
            })

        })
    </script>

@endpush
