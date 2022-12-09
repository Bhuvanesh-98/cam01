@extends('admin.layout.master')

@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Blog Categories')</h1>
      
          
        
          </div>
</section>
@endsection

@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                        <h4>

                            <button class="btn btn-primary add"><i
                                    class="fa fa-plus"></i>
                                @changeLang('Add Category')</button>
                        </h4>
                       
                  
                </div>
                <div class="card-body text-center">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>@changeLang('Sl')</th>
                                <th>@changeLang('Name')</th>
                                <th>@changeLang('Slug')</th>
                                <th>@changeLang('Action')</th>
                            </tr>
                            @forelse ($categories as $key => $category)
                                <tr>

                                <td>
                                    {{$key + $categories->firstItem()}}
                                
                                </td>

                                    <td>{{ $category->name }}</td>
                                    
                                    <td>{{ $category->slug }}</td>
                                   

                                   
                                    <td>

                                        <button data-href="{{ route('admin.frontend.blog.update', $category) }}" class="btn btn-primary edit" data-category="{{$category}}"><i
                                                class="fa fa-pen"></i></button>
                                        <a href="" data-url="{{ route('admin.frontend.blog.delete', $category) }}"
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

    
    
    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <form action="" method="POST">
        @csrf
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">@changeLang('Add Blog Category')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="form-group col-md-12">

                                <label for="">@changeLang('Category Name')</label>
                                <input type="text" name="name" class="form-control">
                            
                            </div>
                            
                            <div class="form-group col-md-12">

                                <label for="">@changeLang('Category Slug')</label>
                                <input type="text" name="slug" class="form-control">
                            
                            </div>
                        
                        
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                    <button type="submit" class="btn btn-primary">@changeLang('Save')</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    
  

    <div class="modal fade" tabindex="-1" role="dialog" id="delete">
        <div class="modal-dialog" role="document">
            <form action="" method="POST">
                @csrf
               
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

            $('.add').on('click',function(e){
                e.preventDefault();
                const modal = $('#modelId');
                 modal.find('.modal-title').text("{{changeDynamic('Add Blog Category')}}")
                 modal.find('input[name=name]').val('')
                modal.find('input[name=slug]').val('')
                modal.find('form').attr('action','')
                modal.modal('show');
            }) 
            
            $('.edit').on('click',function(e){
                e.preventDefault();
                const modal = $('#modelId');
                modal.find('.modal-title').text("{{changeDynamic('Update Blog Category')}}")
                modal.find('input[name=name]').val($(this).data('category').name)
                modal.find('input[name=slug]').val($(this).data('category').slug)
                modal.find('form').attr('action',$(this).data('href'))
               
                modal.modal('show');
            })

            $('.delete').on('click', function(e) {
                e.preventDefault();
                const modal = $('#delete');
                modal.find('form').attr('action', $(this).data('url'));
                modal.modal('show');
            })
        })
    </script>


@endpush
