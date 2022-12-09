@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
            @if (request()->routeIs('admin.withdraw.pending'))
            <h1>@changeLang('Pending Withdraws')</h1>
            @elseif (request()->routeIs('admin.withdraw.accepted'))
            <h1>@changeLang('Accepted Withdraws')</h1>
            @else
                 <h1>@changeLang('Rejected Withdraws')</h1>
            @endif
      
          
        
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
                                <th>@changeLang('Withdraw Amount')</th>
                                <th>@changeLang('Charge Type')</th>
                                <th>@changeLang('Charge')</th>
                                <th>@changeLang('status')</th>
                                <th>@changeLang('Action')</th>
                            </tr>
                            @forelse ($withdrawlogs as $key => $withdrawlog)
                                <tr>
                                    <td>{{$key + $withdrawlogs->firstItem()}}</td>
                                    <td>{{ __($general->currency_icon . '  ' . $withdrawlog->amount) }}</td>
                                    <td>
                                       {{ucwords($withdrawlog->withdraw->charge_type)}}
                                    </td>
                                    <td>
                                       {{number_format($withdrawlog->charge,2)}}
                                    </td> 
                                

                                    <td>

                                        @if($withdrawlog->status == 1)
                                            
                                            <span class="badge badge-success">@changeLang('Success')</span>

                                        @elseif($withdrawlog->status == 2)
                                             <span class="badge badge-danger">@changeLang('Rejected')</span>
                                        @else
                                            <span class="badge badge-warning">@changeLang('Pending')</span>

                                        @endif
                                    
                                    
                                    </td>

                                    <td>
                                    
                                        <button class="btn btn-info details" data-user_data="{{json_encode($withdrawlog->user_data)}}" data-transaction="{{$withdrawlog->trx}}" data-provider="{{$withdrawlog->user->fullname}}" data-method_name="{{$withdrawlog->withdraw->name}}" data-date="{{ __($withdrawlog->created_at->format('d F Y')) }}">@changeLang('Details')</button>

                                        @if($withdrawlog->status == 0)

                                            <button class="btn btn-primary accept" data-url="{{route('admin.withdraw.accept', $withdrawlog)}}" >@changeLang('Accept')</button>
                                            <button class="btn btn-danger reject" data-url="{{route('admin.withdraw.reject',$withdrawlog)}}">@changeLang('Reject')</button>

                                        @endif

                                    
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
                @if ($withdrawlogs->hasPages())
                    {{ $withdrawlogs->links('frontend.partials.paginate') }}
                @endif
            </div>
        </div>
    </div>


    
    <!-- Modal -->
    <div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">

           
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">@changeLang('Withdraw Details')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid withdraw-details">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                    
                </div>
            </div>
           
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="accept" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">

           <form action="" method="post">
           @csrf
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">@changeLang('Withdraw Accept')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <p>@changeLang('Are you sure to Accept this withdraw request')?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                    <button type="submit" class="btn btn-primary" >@changeLang('Accept')</button>
                    
                </div>
            </div>
           </form>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

           <form action="" method="post">
           @csrf
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">@changeLang('Withdraw Reject')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group col-md-12">

                            <label for="">@changeLang('Reason Of Reject')</label>
                            <textarea name="reason_of_reject" id="" cols="30" rows="10" class="form-control"> </textarea>
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                    <button type="submit" class="btn btn-danger" >@changeLang('Reject')</button>
                    
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

            $('.details').on('click',function(){
                const modal = $('#details');

                let html = `
                
                    <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                               @changeLang('Withdraw Method Email')
                                <span>${$(this).data('user_data').email}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @changeLang('Withdraw Account Information')
                                <span>${$(this).data('user_data').account_information}</span>
                            </li> 
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @changeLang('Transaction Id')
                                <span>${$(this).data('transaction')}</span>
                            </li>  
                            
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @changeLang('Provider Name')
                                <span>${$(this).data('provider')}</span>
                            </li> 
                            
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @changeLang('Withdraw Method')
                                <span>${$(this).data('method_name')}</span>
                            </li> 
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @changeLang('Withdraw Date')
                                <span>${$(this).data('date')}</span>
                            </li> 
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @changeLang('Note For Withdraw')
                                <span>${$(this).data('user_data').note}</span>
                            </li>
                            
                        </ul>
                
                
                `;

                modal.find('.withdraw-details').html(html);

                modal.modal('show');
            })

            $('.accept').on('click',function(){
                 const modal = $('#accept');

                 modal.find('form').attr('action', $(this).data('url'));
                 modal.modal('show');
            })
            
            $('.reject').on('click',function(){
                 const modal = $('#reject');

                 modal.find('form').attr('action', $(this).data('url'));
                 modal.modal('show');
            })

        })
    
    
    </script>
    
@endpush

