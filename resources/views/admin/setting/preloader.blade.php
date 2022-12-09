@extends('admin.layout.master')

@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Preloader Settings')</h1>
      
          
        
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

                            <div class="form-group col-md-12 mb-3">
                                <label class="col-form-label">@changeLang('Preloader Image')</label>

                                <div id="image-preview" class="image-preview"
                                    style="background-image:url({{ getFile('preloader', @$general->preloader_image) }});">
                                    <label for="image-upload" id="image-label">@changeLang('Choose File')</label>
                                    <input type="file" name="preloader_image" id="image-upload" />
                                </div>

                            </div>

                            <div class="form-group col-md-6">

                                <label for="">@changeLang('Allow Preloader')</label>

                                <select name="preloader_status" id="" class="form-control">
                                
                                    <option value="1" {{$general->preloader_status ? 'selected' : ''}}>@changeLang('Yes')</option>
                                    <option value="0" {{$general->preloader_status ? '' : 'selected'}}>@changeLang('No')</option>

                                </select>

                            </div>
                            
                            <div class="form-group col-md-8">

                               <button type="submit" class="btn btn-primary">@changeLang('Preloader Update')</button>

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
    
        $(function(){
            'use strict'

            
            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "Choose File", // Default: Choose File
                label_selected: "Update Image", // Default: Change File
                no_label: true, // Default: false
                success_callback: null // Default: null
            });
        })
    
    </script>

@endpush