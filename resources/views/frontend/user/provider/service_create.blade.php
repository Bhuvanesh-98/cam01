@extends('frontend.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Create Service')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <h4><a href="{{ route('user.service') }}" class="btn btn-primary"> <i class="fa fa-arrow-left"></i>
                            @changeLang('Back')</a></h4>

                </div>
                <div class="card-body">

                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">


                            <div class="form-group col-12 col-md-6 col-lg-3">
                                <label class="">@changeLang('Service Image')</label>

                                <div id="image-preview" class="image-preview w-100">
                                    <label for="image-upload" id="image-label">@changeLang('Choose File')</label>
                                    <input type="file" name="service_image" id="image-upload" />
                                </div>

                            </div>

                            <div class="col-12 col-md-6 col-lg-9">

                                <div class="row">

                                    <div class="form-group col-md-6 col-lg-6">
                                        <label for="">@changeLang('Category') <span class="text-danger">*</span></label>
                                        <select name="category" id="" class="form-control">

                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="">@changeLang('Service Name') <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control form_control"
                                            >

                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>@changeLang('Service Rate') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    {{ $general->currency_icon }}
                                                </div>
                                            </div>
                                            <input type="text" name="rate" class="form-control form_control currency"
                                                >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="">@changeLang('Service Duration') <span class="text-danger">*</span></label>
                                        <select name="duration" id="" class="form-control">
                                            <option value="0">@changeLang('Hourly')</option>
                                            <option value="1">@changeLang('Daily')</option>
                                            <option value="2">@changeLang('Weekly')</option>
                                            <option value="3">@changeLang('Monthly')</option>
                                            <option value="4">@changeLang('Yearly')</option>
                                            <option value="5">@changeLang('Fixed')</option>
                                        </select>

                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="">
                                        @changeLang('Service Location (please write , separated location) ') <span class="text-danger">*</span></label>
                                       <input type="text" name="location" class="form-control" >
                                       
                                    </div>

                                   


                                </div>

                            </div>


                            <div class="form-group col-md-12">

                                <label for="">@changeLang('Service Details') <span class="text-danger">*</span></label>
                                <textarea name="details" id="" cols="30" rows="5" class="form-control"
                                    ></textarea>
                            </div>

                            <div class="form-group col-md-12">


                                <div class="col-md-12 text-right">
                                    <button class="btn btn-primary faq"> <i class="fa fa-plus"></i> 
                                    @changeLang('Add Questions')</button>
                                </div>

                                <div class="row addFaq align-items-center">

                                    <div class="form-group col-md-5">

                                        <label for="">@changeLang('Question')</label>

                                        <input type="text" name="faq[0][question]" class="form-control"
                                            >

                                    </div>

                                    <div class="form-group col-md-5">

                                        <label for="">@changeLang('Answer')</label>

                                        <input type="text" name="faq[0][answer]" class="form-control"
                                            >

                                    </div>




                                </div>


                                <div class="col-md-12 text-right">
                                    <button class="btn btn-primary video"> <i class="fa fa-plus"></i> 
                                    @changeLang('Add Video')</button>
                                </div>
                                <div class="row addVideo">

                                    <div class="form-group col-md-10">

                                        <label for="">@changeLang('YouTube Video Id')</label>

                                        <input type="text" name="video[]" class="form-control"
                                            >
                                    </div>



                                </div>


                                <div class="col-md-12 text-right">
                                    <button class="btn btn-primary gallery-btn"> <i class="fa fa-plus"></i> @changeLang('Add Gallery')</button>
                                </div>

                                <div class="row addImage">

                                    <div class="form-gorup col-md-4 mt-3">
                                        <div class="w-100 image-area">
                                            <img src="" alt="@changeLang('image')" class="image-prev-0 d-none">
                                        </div>

                                        <input type="file" name="gallery_image[]" class="form-control image mt-2">


                                    </div>


                                </div>


                            </div>


                            <div class="form-group col-md-12">
                                <button class="btn btn-primary" type="submit">@changeLang('Create Service')</button>
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
            var i = 1;
            var j = 1;
            $('.faq').on('click', function(e) {
                e.preventDefault();

                var html = `
             
                            <div class="deleteData col-md-12">
                            
                                <div class="row align-items-center">

                                    <div class="form-group col-md-5 ">

                                        <label for="">@changeLang('Question')</label>

                                        <input type="text" name="faq[${i}][question]" class="form-control"
                                            >

                                    </div>

                                    <div class="form-group col-md-5 ">

                                        <label for="">@changeLang('Answer')</label>

                                        <input type="text" name="faq[${i}][answer]" class="form-control"
                                            >

                                    </div>

                                    <div class="form-group col-md-2 ">
                                        <label for=""></label>
                                        <button class="btn btn-danger w-100 delete"><i class="fa fa-times"></i></button>
                                    </div>


                                </div>
                            
                            
                            </div>
             
             `;
                $('.addFaq').append(html);

                i++
            })


            $('.video').on('click', function(e) {
                e.preventDefault();
                var video = `
                
                    <div class="col-md-12 videoDelete">

                         <div class="row align-items-center">

                                    <div class="form-group col-md-10">
                                            
                                            <label for="">@changeLang('YouTube Video id')</label>

                                            <input type="text" name="video[]" class="form-control" >
                                    </div>


                                     <div class="form-group col-md-2 ">
                                        <label for=""></label>
                                        <button class="btn btn-danger w-100 delete-v"><i class="fa fa-times"></i></button>
                                    </div>



                                </div>


                    </div>
                
                
                `;

                $('.addVideo').append(video);
            })

            $('.gallery-btn').on('click', function(e) {

                e.preventDefault();

                var gallery = `
                
                                    <div class="form-gorup col-md-4 mt-3 remove-gallery">
                                        <div class="w-100 image-area">
                                         <button class="delete-image"><i class="fa fa-times"></i></button>
                                            <img src="" alt="" class="image-prev-${j} w-100 d-none">
                                        </div>

                                        <input type="file" name="gallery_image[]" class="form-control image mt-2" >
                                    
                                    
                                    </div>
                
                
                `;

                $('.addImage').append(gallery);

                j++;


            })

            $(document).on('click', '.delete', function() {
                $(this).closest('.deleteData').remove();
            });
            $(document).on('click', '.delete-v', function() {
                $(this).closest('.videoDelete').remove();
            });

            $(document).on('click', '.delete-image', function(e) {
                e.preventDefault();
                $(this).closest('.remove-gallery').remove();
            });


            function showImagePreview(input, index) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                   
                        $('.image-prev-' + index).removeClass('d-none')
                        $('.image-prev-' + index).attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(document).on('change', '.image', function() {
                let index = $('.image').index(this);
                showImagePreview(this, index);
            });

            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "{{changeDynamic('Choose File')}}", // Default: Choose File
                label_selected: "{{changeDynamic('Upload File')}}", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });

             $(".auto-tokenizer").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            })

        })
    </script>


@endpush


@push('custom-style')

    <style>
        .image-area {
            border: 1px dashed gray;
            height: 300px;
            position: relative;
        }

        .image-area img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .delete-image {
            position: absolute;
            right: 0;
            background: red;
            border: none;
        }

        .delete-image i {
            color: #fff;
        }

    </style>

@endpush
