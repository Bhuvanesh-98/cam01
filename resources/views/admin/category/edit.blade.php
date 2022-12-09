@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
         
            <h1>@changeLang('Edit Category')</h1>
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <a href="{{ route('admin.category.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i>
                        @changeLang('Back')</a>

                </div>

                <div class="card-body">

                    <form action="{{route('admin.category.update',$category)}}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PATCH')


                        <div class="row">


                            <div class="form-group col-md-6">

                                <label for="">@changeLang('Category Name')</label>
                                <input type="text" name="name"
                                    class="form-control form_control" value="{{$category->name}}">


                            </div>


                            <div class="form-group col-md-6">

                                <label for="">@changeLang('Category Status')</label>
                                <select name="status" id="" class="form-control">

                                    <option value="1" {{$category->status ? 'selected' : ''}}>@changeLang('Active')</option>
                                    <option value="0" {{$category->status ? '' : 'selected'}}>@changeLang('Inactive')</option>

                                </select>


                            </div>

                            <div class="form-group col-md-3">
                                <label class="col-form-label">@changeLang('Category Image')</label>

                                <div id="image-preview" class="image-preview" style="background-image:url({{getFile('category',$category->image)}});">
                                    <label for="image-upload" id="image-label">@changeLang('Choose File')</label>
                                    <input type="file" name="image" id="image-upload" />
                                </div>

                            </div>



                            <div class="form-group col-md-12">
                            
                                <button type="submit" class="btn btn-primary">@changeLang('Update Category')</button>
                            
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
            label_selected: "{{changeDynamic('Choose File')}}", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

    })
    </script>


@endpush
