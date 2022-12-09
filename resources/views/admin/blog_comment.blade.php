@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Blog Comments')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                
                <div class="card-body text-center">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>@changeLang('Sl')</th>
                                <th>@changeLang('Email')</th>
                                <th>@changeLang('Phone')</th>
                                <th>@changeLang('Status')</th>
                                <th>@changeLang('Action')</th>
                            
                            </tr>

                            @forelse ($comments as $key => $comment)
                                <tr>
                                
                                    <td>{{$key + $comments->firstItem()}}</td>
                                    <td>{{$comment->email}}</td>
                                    <td>{{$comment->phone}}</td>
                                   
                                    <td>
                                        @if ($comment->disabled)
                                            <span class="badge badge-primary">@changeLang('Active')</span>

                                        @else   
                                           <span class="badge badge-danger">@changeLang('Inactive')</span>      
                                        @endif
                                    </td>

                                    <td>

                                        <button class="btn btn-primary message" data-url="{{route('admin.blog.comment.update', $comment)}}" data-message="{{clean(strip_tags($comment->comment))}}"><i class="fa fa-pen"></i></button>
                                        <a href="{{route('admin.frontend.element.edit',['blog',$comment->blog_id])}}" class="btn btn-primary">@changeLang('Blog Details')</a>

                                    
                                    </td>
                                
                                
                                </tr>                                
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">@changeLang('No comments Found')</td>                                
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>

                @if ($comments->hasPages())
                    
                <div class="card-footer">
                    {{$comments->links('admin.partials.paginate')}}
                </div>
                @endif
            </div>
        </div>
    </div>

   
    
    <!-- Modal -->
    <div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="post">
            @csrf
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">@changeLang('comment Message')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                       <p class="message-text"></p>

                       <div class="row">

                            <div class="form-group col-md-12">
                            
                                <label for="">@changeLang('Change Status')</label>
                                <select name="status" id="" class="form-control">

                                    <option value="1">@changeLang('Active')</option>
                                    <option value="0">@changeLang('Inactive')</option>
                                
                                </select>
                            
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
   
@endsection


@push('custom-script')
    <script>
    
        $(function(){
            'use strict'

            $('.message').on('click',function(){
                const modal = $('#message');
                
                modal.find('.message-text').text($(this).data('message'))

                modal.find('form').attr('action', $(this).data('url'));

                modal.modal('show')
            })
        })
    
    
    </script>    
@endpush