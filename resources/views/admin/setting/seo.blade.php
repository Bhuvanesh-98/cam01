@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Global Seo Settings')</h1>
      
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post">

                        @csrf

                        <div class="row">

                                    <div class="form-group col-md-12">

                                        <label for="">@changeLang('Seo Description')</label>

                                        <textarea name="seo_description" id="" cols="30" rows="10" class="form-control"
                                            >{{__(clean($general->seo_description))}}</textarea>

                                    </div>








                            <div class="form-group col-md-12">


                                <button type="submit" class="btn btn-primary w-100">@changeLang('Update Seo')</button>

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

            $(".select2-auto-tokenize").select2({
                tags: true,
                tokenSeparators: [',']
            });

            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "Choose File", // Default: Choose File
                label_selected: "Update Image", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });
        })
    </script>

@endpush
