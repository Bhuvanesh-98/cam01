@extends('admin.layout.master')

@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Login Page Settings')</h1>
      
          
        
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
                            <div class="form-group col-md-3 mb-3">
                                <label class="col-form-label">@changeLang('Admin Login Page Image')</label>

                                <div id="image-preview" class="image-preview"
                                    style="background-image:url({{ getFile('login',@$general->login_page->login_image) }});">
                                    <label for="image-upload" id="image-label">@changeLang('Choose File')</label>
                                    <input type="file" name="login_image" id="image-upload" />
                                </div>

                            </div>

                            <div class="form-group col-md-9">

                                <div class="row">

                                    <div class="form-group col-md-12">

                                        <label for="">@changeLang('Image Overlay Text')</label>
                                        <input type="text" name="overlay" 
                                            class="form-control" value="{{@$general->login_page->overlay}}">

                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                       <button type="submit" class="btn btn-primary">@changeLang('Update Login Setting')</button>

                                    </div>



                                </div>

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
                label_default: "{{changeDynamic('Choose File')}}", // Default: Choose File
                label_selected: "{{changeDynamic('Update Image')}}", // Default: Change File
                no_label: true, // Default: false
                success_callback: null // Default: null
            });
        })
    
    </script>

@endpush