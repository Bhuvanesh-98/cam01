@extends('admin.layout.master')

@section('breadcrumb')
    <section class="section">
        <div class="section-header">

            <h1>{{ changeDynamic($pageTitle) }}</h1>



        </div>
    </section>
@endsection

@section('content')


    <div class="row">

        <div class="col-md-6">


            <div class="card">

                <div class="card-body">

                    <div class="row">

                        <form action="" method="POST" class="col-md-12">
                            @csrf
                            <div class="row">

                                <div class="col-md-12">
                                    <h6>@changeLang('Add Sections')</h6>

                                    <p>@changeLang('Drag Here sections you want to add')</p>
                                    <ol class="simple_with_drop vertical section_style draggable-area ">


                                    </ol>

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="">@changeLang('Page Name')</label>

                                    <input type="text" name="page" class="form-control" required>

                                </div>
                                
                                 <div class="form-group col-md-6">

                                    <label for="">@changeLang('Page Order')</label>

                                    <input type="text" name="page_order" class="form-control" required>

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="">@changeLang('status')</label>

                                    <select name="status" class="form-control">

                                        <option value="1">@changeLang('Active')</option>
                                        <option value="0">@changeLang('Inactive')</option>

                                    </select>

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="">@changeLang('Is Dropdown')</label>

                                    <select name="dropdown" class="form-control">

                                        <option value="1">@changeLang('Yes')</option>
                                        <option value="0">@changeLang('No')</option>

                                    </select>

                                </div>



                               

                                <div class="form-group col-md-12">

                                    <label for="">@changeLang('Seo Description')</label>
                                    <textarea name="seo_description" id="" cols="30" rows="5"
                                        class="form-control">{{ old('seo_description') }}</textarea>

                                </div>

                                <div class="form-group col-md-12 custom-section d-none">

                                    <label for="">@changeLang('Custom Section')</label>
                                    <textarea name="custom_section" id="" cols="30" rows="5"
                                        class="form-control summernote">{{ old('custom_section') }}</textarea>

                                </div>


                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">@changeLang('Add Page')</button>
                                </div>



                            </div>


                        </form>




                    </div>

                </div>


            </div>


        </div>

        <div class="col-md-6 section-bar">


            <div class="card">

                <div class="card-body p-0">

                    <ol class="simple_with_no_drop vertical d-flex flex-wrap justify-content-between">
                        @foreach ($sections as $key => $section)

                            <li class="highlight icon-move clearfix w-45" data-item="{{ $key }}">
                                <i class=" fa fa-arrows-alt text-white mt-2"></i>
                                <span class="d-inline-block  mr-auto ml-2 mt-2">{{ ucwords($key) . ' Section' }}</span>
                                <i class="ml-auto d-inline-block remove-icon fa fa-times"></i>
                                <input type="hidden" name="sections[]" value="{{ $key }}">


                            </li>
                        @endforeach

                    </ol>


                </div>


            </div>




        </div>


    </div>


@endsection
@push('custom-script')
    <script>
        (function($) {
            "use strict";
            let is_added = false
            $("ol.simple_with_drop").sortable({
                group: 'no-drop',
                handle: '.icon-move',
                onDragStart: function($item, container, _super) {
                   
                    if ($item.data('item') == 'custom') {
                        $('.custom-section').removeClass('d-none')
                        is_added = true;
                    } else {
                        if(is_added == false){
                            $('.custom-section').addClass('d-none')
                        }
                    }
                    // Duplicate items of the no drop area
                    if (!container.options.drop) {
                        $item.clone().insertAfter($item);
                    }
                    _super($item, container);
                }
            });
            $("ol.simple_with_no_drop").sortable({
                group: 'no-drop',
                drop: false
            });
            $("ol.simple_with_no_drag").sortable({
                group: 'no-drop',
                drag: false
            });
            $(".remove-icon").on('click', function() {
               
                if( $(this).parent('.highlight').data('item') == 'custom'){
                    $('.custom-section').addClass('d-none')
                    $(this).parent('.highlight').remove();
                }else{
                    
                    $(this).parent('.highlight').remove();

                }
                
            });

        })(jQuery);
    </script>
@endpush


@push('custom-style')
    <style>
        .w-45 {
            width: 45%;
        }

        .simple_with_drop .w-45 {
            width: 100%;
        }

        ol li.highlight {
            background: #000;
            color: #999999;
        }

        ol.vertical {
            margin: 0 0 9px 0;
            min-height: 150px;
        }

        li {
            line-height: 18px;
        }

        .icon-move {
            background-position: -168px -72px;
        }

        ol i.icon-move {
            cursor: pointer;
        }

        ol {
            display: block;
            list-style-type: decimal;
            margin-block-start: 1em;
            margin-block-end: 1em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
        }

        .vertical li i {
            color: #000000;
            padding-right: 15px;
        }

        .draggable-area {
            border: 1px dashed lightgray;
            height: auto;
            text-align: center
        }

        .section_style li i {
            color: #000000;
            padding-right: 15px;
        }

        .section_style li i.fa-times {
            color: #ea5455;
            padding-right: 15px;
        }

             .remove-icon{
            cursor: pointer;
        }

        ol.vertical li {
            display: block;
            margin: 10px 11px;
            padding: 10px;
            color: #e0e0e0;
            background: #7f7ff7;
            font-size: 16px;
            font-weight: 600;
             cursor:move;
        }

        ol.section_style li {
            margin: 10px -18px;
            padding: 10px;
            color: #fff;
            background: #17845ba8;
            font-size: 24px;
            font-weight: 600;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .ol.section_style li.d-none {
            display: none !important;
        }

        [class*="span"] {
            float: left;
            margin-left: 20px;
        }

        .row {
            margin-left: -20px;
            *zoom: 1;
        }

        .row {
            position: relative;
        }

        .dragged {
            position: absolute;
            top: 0;
            opacity: 0.5;
            z-index: 2000;
            background: #333333;
            color: #999999;
        }

        ol.vertical li i.remove-icon {
            display: none !important;
        }

        ol.section_style li i.remove-icon {
            display: block !important;
            color: #fff;
        }

        ol.section_style li .manage-content {
            display: none !important;
        }

        ol.vertical li span {
            font-size: 15px;
        }

        .cog-btn i {
            color: #fff !important
        }

        .cog-btn:hover i {
            color: #000 !important
        }

    </style>
@endpush
