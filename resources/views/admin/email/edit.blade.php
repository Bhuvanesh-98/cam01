@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Update Email Template')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-9 col-md-9 col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <h5>@changeLang('Variables Meaning')</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>@changeLang('Variable')</th>
                                <th>@changeLang('Meaning')</th>
                            </tr>

                            @foreach ($template->meaning as $key => $temp)
                                <tr>

                                    <td>{{ '{' . $key . '}' }}</td>
                                    <td>{{ $temp }}</td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-9 col-md-9 col-lg-9">
            <div class="card">
                <div class="card-body">

                    <form action="" method="post">

                        @csrf

                        <div class="row">


                            <div class="form-group col-md-12">

                                <label for="">@changeLang('Subject')</label>
                                <input type="text" name="subject"  class="form-control" value="{{ $template->subject }}">


                            </div>

                            <div class="form-group col-md-12">

                                <label for="">@changeLang('Template')</label>
                                <textarea name="template" 
                                    class="form-control summernote">{{clean($template->template)}}</textarea>

                            </div>


                            <button type="submit" class="btn btn-primary">@changeLang('Update Email Template')</button>


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
            $('.summernote').summernote();
        })
    </script>
@endpush