@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
           
                 <h1>@changeLang('All Subscribers')</h1>

           
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                        <h4>

                            <button class="btn btn-primary send-all">
                                @changeLang('Send Mail To All Subscribers')</button>
                        </h4>

                
                </div>
                <div class="card-body text-center">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr class="text-left">
                                <th>@changeLang('Sl')</th>
                                <th>@changeLang('Email')</th>
                                <th>@changeLang('Subscription Date')</th>
                                <th>@changeLang('Action')</th>
                            </tr>
                            @forelse ($subscribers as $key => $subscriber)
                                <tr class="text-left">

                                    <td>{{ $key + $subscribers->firstItem() }}</td>
                                    <td>{{ $subscriber->email }}</td>
                                   
                                    <td>
                                       {{$subscriber->created_at->format('d F Y')}}
                                    </td>
                                    <td>

                                        <button data-href="{{ route('admin.subscription.single', $subscriber) }}" class="btn btn-primary single">@changeLang('Send Mail')</button>

                                        <button data-url="{{ route('admin.subscription.delete', $subscriber) }}"
                                            class="btn btn-danger delete"><i class="fa fa-trash"></i></button>

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
                @if ($subscribers->hasPages())
                    {{ $subscribers->links('admin.partials.paginate') }}
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="delete">
        <div class="modal-dialog" role="document">
            <form action="" method="POST">
                @csrf
               
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@changeLang('Delete Subscriber')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">@changeLang('Are You Sure to Delete this Subscriber')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                        <button type="submit" class="btn btn-danger">@changeLang('Delete')</button>
                    </div>
                </div>
            </form>
        </div>
    </div> 
    
    
    <div class="modal fade" tabindex="-1" role="dialog" id="send-all">
        <div class="modal-dialog" role="document">
            <form action="{{route('admin.subscription.all')}}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@changeLang('Send Mail To All Subscribers')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <div class="row">
                       
                        <div class="from-group col-md-12">

                            <label for="">@changeLang('Subject')</label>
                            <input type="text" name="subject" class="form-control">
                        
                        </div>
                        
                        <div class="from-group col-md-12 mt-3">

                            <label for="">@changeLang('Message')</label>
                            <textarea name="message" id="" cols="30" rows="10" class="form-control summernote"></textarea>
                        
                        </div>
                       
                       </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                        <button type="submit" class="btn btn-primary">@changeLang('Send')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    
    <div class="modal fade" tabindex="-1" role="dialog" id="single">
        <div class="modal-dialog" role="document">
            <form action="" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@changeLang('Send Mail To this Subscriber')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <div class="row">
                       
                        <div class="from-group col-md-12">

                            <label for="">@changeLang('Subject')</label>
                            <input type="text" name="subject" class="form-control">
                        
                        </div>
                        
                        <div class="from-group col-md-12 mt-3">

                            <label for="">@changeLang('Message')</label>
                            <textarea name="message" id="" cols="30" rows="10" class="form-control summernote"></textarea>
                        
                        </div>
                       
                       </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                        <button type="submit" class="btn btn-primary">@changeLang('Send')</button>
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

            $('.send-all').on('click',function(){
                const modal = $('#send-all');


                modal.modal('show')
            })
            
            $('.single').on('click',function(){
                const modal = $('#single');

                modal.find('form').attr('action', $(this).data('href'))
                modal.modal('show')
            })
        })
    </script>


@endpush
