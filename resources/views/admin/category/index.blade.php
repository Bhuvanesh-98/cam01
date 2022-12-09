@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
         
            <h1>@changeLang('Manage Categories')</h1>
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    @if (request()->routeIs('admin.category.search'))
                        <h4>

                            <a href="{{ route('admin.category.index') }}" class="btn btn-primary"><i
                                    class="fa fa-arrow-left"></i>
                                @changeLang('Back')</a>
                        </h4>

                    @else


                        <h4>

                            <a href="{{ route('admin.category.create') }}" class="btn btn-primary"><i
                                    class="fa fa-plus"></i>
                                @changeLang('Add Category')</a>
                        </h4>
                        <div class="card-header-form">
                            <form method="GET" action="">
                                <div class="input-group">
                                    <input type="text" class="form-control"  name="search">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
                <div class="card-body text-center">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>@changeLang('Sl')</th>
                                <th>@changeLang('Name')</th>
                                <th>@changeLang('Image')</th>
                                <th>@changeLang('Status')</th>
                                <th>@changeLang('Action')</th>
                            </tr>
                            @forelse ($categories as $key => $category)
                                <tr>

                                <td>
                                    {{$key + $categories->firstItem()}}
                                
                                </td>

                                    <td>{{ $category->name }}</td>
                                    <td>

                                        <img alt="image" src="{{ getFile('category', $category->image) }}"
                                            class="image-rounded my-2" data-toggle="tooltip" title=""
                                            data-original-title="{{ $category->name }}">

                                    </td>

                                    <td>
                                        @if ($category->status)
                                            <div class="badge badge-success">@changeLang('Active')</div>
                                        @else
                                            <div class="badge badge-danger">@changeLang('Inactive')</div>
                                        @endif
                                    </td>
                                    <td>

                                        <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-primary"><i
                                                class="fa fa-pen"></i></a>
                                        <a href="" data-url="{{ route('admin.category.destroy', $category) }}"
                                            class="btn btn-danger delete"><i class="fa fa-trash"></i></a>

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
                @if ($categories->hasPages())
                    {{ $categories->links('admin.partials.paginate') }}
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="delete">
        <div class="modal-dialog" role="document">
            <form action="" method="POST">
                @csrf
                @method("DELETE")
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@changeLang('Delete Category')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">@changeLang('Are You Sure to Delete this Category')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                        <button type="submit" class="btn btn-danger">@changeLang('Delete')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection


@push('custom-script')


    <script>
        $(function() {
            'use strict'

            $('.delete').on('click', function(e) {
                e.preventDefault();
                const modal = $('#delete');
                modal.find('form').attr('action', $(this).data('url'));
                modal.modal('show');
            })
        })
    </script>


@endpush
