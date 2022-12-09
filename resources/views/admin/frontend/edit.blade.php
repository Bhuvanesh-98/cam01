@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Update Element Data')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')



    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <form method="post" action="" enctype="multipart/form-data">
                    @csrf

                    <a href="{{route('admin.frontend.section.manage', request()->name)}}" class="btn btn-primary m-3"> <i class="fas fa-arrow-left"></i> @changeLang('Go back')</a>
                    <div class="card-body">
                        <div class="row">
                           
                            @foreach ($section as $key => $sec)
                            @if($key == 'is_category')
                                      <div class="form-group col-md-6">

                                        <label for="">@changeLang('Category Name')</label>
                                       <select name="category" class="form-control">

                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}" {{$element->category == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                            @endforeach
                                        
                                        </select>

                                    </div>
                              @elseif($sec == 'text')
                                    <div class="form-group col-md-6">

                                        <label for="">{{ changeDynamic(frontendFormatter($key)) }}</label>
                                        <input type="{{ $sec }}" name="{{ $key }}"
                                             class="form-control"
                                            value="{{ $element->data->$key }}">

                                    </div>

                                @elseif($sec == 'file')

                                    <div class="form-group col-md-12 mb-3">
                                        <label
                                            class="col-form-label">{{ changeDynamic(frontendFormatter($key)) }}</label>
                                        
                                            <div id="image-preview" class="image-preview" style="background-image:url({{getFile($name, $element->data->$key)}});">
                                                <label for="image-upload" id="image-label">@changeLang('Choose File')</label>
                                                <input type="{{ $sec }}" name="{{ $key }}" id="image-upload" />
                                            </div>
                                        
                                    </div>


                                @elseif($sec == 'textarea')

                                    <div class="form-group col-md-12">

                                        <label for="">{{ changeDynamic(frontendFormatter($key)) }}</label>
                                        <textarea name="{{ $key }}" 
                                            class="form-control">{{ clean($element->data->$key ?? old($key)) }}</textarea>

                                    </div>

                                @elseif($sec == 'textarea_nic')

                                    <div class="form-group col-md-12">

                                        <label for="">{{ changeDynamic(frontendFormatter($key)) }}</label>
                                        <textarea name="{{ $key }}" 
                                            class="form-control summernote">{{ clean($element->data->$key ?? old($key)) }}</textarea>

                                    </div>

                                @elseif($sec == 'icon')

                                 <div class="form-group col-md-6">
                                        <div class="input-group">
                                            <label for="" class="w-100">{{ changeDynamic(frontendFormatter($key)) }}</label>
                                            <input type="text" class="form-control icon-value" name="{{ $key }}"
                                                 value="{{ $element->data->$key }}">
                                            <span class="input-group-append">
                                                <button class="btn btn-outline-secondary iconpicker" data-icon="fas fa-home"
                                                    role="iconpicker"></button>
                                            </span>
                                        </div>
                                    </div>

                                   

                                @endif

                            @endforeach

                            <div class="form-group col-md-12">

                                <button type="submit" class="form-control btn btn-primary">@changeLang('Update')</button>

                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>


    </div>


@endsection

@push('custom-script')

    <script>
        $(function() {
            'use strict'
            $('.summernote').summernote();
            $('.iconpicker').iconpicker();

            $('.iconpicker').on('change', function(e) {
                $('.icon-value').val(e.icon)
            })

            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "{{changeDynamic('Choose File')}}", // Default: Choose File
                label_selected: "{{changeDynamic('Upload File')}}", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });
        })
    </script>


@endpush
