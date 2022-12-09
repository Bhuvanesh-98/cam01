@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Manage Pages')</h1>
      
          
        
          </div>
</section>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4> <a href="{{route('admin.frontend.pages.create')}}" class="btn btn-icon icon-left btn-primary add-page"> <i class="fa fa-plus"></i> @changeLang('Add Page')</a></h4>
                    <div class="card-header-form">
                        <form method="GET" action="{{ route('admin.frontend.search') }}">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search">
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
                            <tr>
                                <th>@changeLang('Sl')</th>
                                <th>@changeLang('Page Name')</th>
                                <th>@changeLang('Page Order')</th>
                                <th>@changeLang('Sections')</th>
                                <th>@changeLang('Action')</th>
                            </tr>

                            @forelse($pages as $key => $page)
                                <tr>

                                    <td>
                                        {{ $key + $pages->firstItem() }}
                                    </td>
                                    <td>
                                        {{ $page->name }}
                                    </td>

                                    <td>{{$page->page_order}}</td>

                                    <td>


                                        @foreach ($page->sections as $section)
                                            {{ __($section) }} @if (!$loop->last) ,
                                            @endif
                                        @endforeach


                                    </td>
                                    <td>

                                        <a href="{{ route('admin.frontend.pages.edit', $page) }}" class="btn btn-icon btn-primary edit"><i class="fa fa-pen"></i></a>
                                    @if(!$loop->first)
                                        <a href="#" class="btn btn-icon btn-danger delete"
                                            data-url="{{ route('admin.frontend.pages.delete', $page) }}"><i
                                                class="fa fa-trash"></i></a>
                                    @endif
                                    </td>
                                </tr>
                            @empty

                                <tr>

                                    <td class="text-center text-danger" colspan="100%">@changeLang('No Data Found')</td>

                                </tr>
                            @endforelse

                        </table>
                    </div>
                </div>

                @if($pages->hasPages())
                    <div class="card-footer">
                        {{$pages->links('admin.partials.paginate')}}
                    </div>
                @endif
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@changeLang('Delete Page')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf

                        <p>@changeLang('Are You Sure To Delete Pages')?</p>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary mr-3"
                                data-dismiss="modal">@changeLang('Close')</button>
                            <button type="submit" class="btn btn-danger">@changeLang('Delete Page')</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection


@push('custom-script')


    <script>
        'use strict'

        $(function() {

            $('.delete').on('click', function() {
                const modal = $('#deleteModal');

                modal.find('form').attr('action', $(this).data('url'))
                modal.modal('show')
            })
        })
    </script>

@endpush
