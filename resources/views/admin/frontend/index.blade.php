@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Add Section Data')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')



    @if (isset($section['content']))

        <div class="row">

            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form method="post" action="" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="row">
                               
                                @foreach ($section['content'] as $key => $sec)
                                    @if ($sec == 'text')
                                        <div class="form-group col-md-6">

                                            <label for="">{{ changeDynamic(frontendFormatter($key)) }}</label>
                                            <input type="{{ $sec }}" name="{{ $key }}"
                                                value="{{ $content !== null ? $content->data->$key : '' }}"
                                                 class="form-control" required>

                                        </div>

                                    @elseif($sec == 'file')
                                        <div class="form-group col-md-12 mb-3">
                                        <label
                                            class="col-form-label">{{ changeDynamic(frontendFormatter($key)) }}</label>
                                        
                                            <div id="image-preview" class="image-preview" style="background-image:url({{getFile(request()->name, @$content->data->$key)}});">
                                                <label for="image-upload" id="image-label">@changeLang('Choose File')</label>
                                                <input type="{{ $sec }}" name="{{ $key }}" id="image-upload" />
                                            </div>
                                        
                                    </div>

                                    @elseif($sec == 'textarea')

                                        <div class="form-group col-md-12">

                                            <label for="">{{ changeDynamic(frontendFormatter($key)) }}</label>
                                            <textarea name="{{ $key }}"
                                                
                                                class="form-control">{{ $content !== null ? clean($content->data->$key) : '' }}</textarea>

                                        </div>

                                    @elseif($sec == 'textarea_nic')

                                        <div class="form-group col-md-12">

                                            <label for="">{{ changeDynamic(frontendFormatter($key)) }}</label>
                                            <textarea name="{{ $key }}"
                                                
                                                class="form-control summernote">{{ $content !== null ? clean($content->data->$key) : '' }}</textarea>

                                        </div>

                                    @elseif($sec == 'icon')

                                        <div class="input-group">
                                            <input type="text" class="form-control" value="My house">
                                            <span class="input-group-append">
                                                <button class="btn btn-outline-secondary" data-icon="fas fa-home"
                                                    role="iconpicker"></button>
                                            </span>
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

    @endif

    @if (isset($section['element']))

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4> <a href="{{ route('admin.frontend.element', request()->name) }}"
                                class="btn btn-icon icon-left btn-primary add-page"> <i class="fa fa-plus"></i> @changeLang('Add Elements')</a></h4>
                         <div class="card-header-form">
                        <form method="GET" action="{{ route('admin.frontend.element.search',request()->name) }}">
                            <div class="input-group">
                                <input type="text" class="form-control"  name="search">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr class="text-center">
                                    <th>@changeLang('Sl').</th>
                                    @php
                                        $keys = [];
                                    @endphp
                                   
                                    @foreach ($section['element'] as $key => $sec)
                                        @if(request()->name != 'brand')
                                        @if ($sec == 'textarea' || $sec == 'file' || $sec == 'textarea_nic' || $sec == 'icon' || $key == 'size' || $sec == 'on'|| $key == 'unique')
                                            @continue
                                        @endif
                                        @else
                                            @if($key == 'size')
                                             @continue
                                            @endif
                                        @endif
                                        <th>{{changeDynamic(frontendFormatter($key))}}</th>
                                        @php
                                            array_push($keys, $key);
                                        @endphp
                                    @endforeach
                                    <th>@changeLang('Action')</th>
                                </tr>

                                @forelse($elements as $element)

                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        @foreach ($keys as $key)
                                           @if($key == 'size' || $key == 'unique')
                                            @continue
                                           @endif
                                            @if(request()->name != 'brand')
                                                <td>{{ $element->data->$key }}</td>
                                            @else
                                                <td><img src="{{getFile(request()->name, $element->data->$key )}}" alt="" class="image-rounded p-2"></td>
                                            @endif
                                        @endforeach
                                        <td>
                                            <a href="{{route('admin.frontend.element.edit', ['name'=>request()->name , 'element'=>$element])}}" class="btn btn-primary"><i class="fa fa-pen"></i></a>

                                            <button class="btn btn-danger delete" data-url="{{route('admin.frontend.element.delete', [request()->name , $element])}}"><i class="fa fa-trash"></i></button>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td class="text-center" colspan="100%">@changeLang('No Data Found')</td>

                                    </tr>

                                @endforelse

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@changeLang('Delete Element')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <form action="" method="POST">
                       @csrf

                        <p>@changeLang('Are You Sure To Delete Element')?</p>
                       
                       <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-3" data-dismiss="modal">@changeLang('Close')</button>
                        <button type="submit" class="btn btn-danger">@changeLang('Delete Page')</button>
                       </div>
                       
                       </form>
                    </div>
                   
                    </div>
                </div>
            </div>
        

    @endif


@endsection


@push('custom-script')

    <script>
        $(function() {
            'use strict'
            $('.summernote').summernote();

            $('.delete').on('click',function(){
                const modal = $('#deleteModal');

                modal.find('form').attr('action', $(this).data('url'))
                modal.modal('show')
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
