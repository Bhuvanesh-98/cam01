@extends('frontend.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('All withdraws')</h1>
      
          
        
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
                                <th>@changeLang('Date')</th>
                                <th>@changeLang('Method Name')</th>
                                <th>@changeLang('Withdraw Amount')</th>
                                <th>@changeLang('Charge Type')</th>
                                <th>@changeLang('Charge')</th>
                                <th>@changeLang('Remaining Balance')</th>
                                <th>@changeLang('status')</th>
                                <th>@changeLang('Action')</th>
                            </tr>
                            @forelse ($withdrawlogs as $key => $withdrawlog)
                                <tr>

                                    <td>{{$key + $withdrawlogs->firstItem() }}</td>
                                    <td>{{ __($withdrawlog->created_at->format('d F Y')) }}</td>
                                    <td>{{ __($withdrawlog->withdraw->name) }}</td>
                                    <td>{{ __($general->currency_icon . '  ' . $withdrawlog->amount) }}</td>
                                    <td>
                                       {{ucwords($withdrawlog->withdraw->charge_type)}}
                                    </td>
                                    <td>
                                       {{number_format($withdrawlog->charge,4)}}
                                    </td> 
                                    

                                    <td>
                                        {{number_format($withdrawlog->balance_remains,4)}}
                                    </td>

                                    <td>

                                        @if($withdrawlog->status)
                                            
                                            <span class="badge badge-success">@changeLang('Success')</span>

                                        @else
                                            <span class="badge badge-warning">@changeLang('Pending')</span>

                                        @endif
                                    
                                    
                                    </td>

                                    <td>
                                    
                                            <button class="btn btn-primary details" data-user_data="{{json_encode($withdrawlog->user_data)}}" data-withdraw="{{$withdrawlog}}">@changeLang('Details')</button>

                                    
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
                               @changeLang('Withdraw Email')
                                <span>${$(this).data('user_data').email}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @changeLang('Withdraw Account Information')
                                <span>${$(this).data('user_data').account_information}</span>
                            </li>

                             
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @changeLang('Note For Withdraw')
                                <span>${$(this).data('user_data').note}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @changeLang('Withdraw Transaction')
                                <span>${$(this).data('withdraw').trx}</span>
                            </li>
                            
                        </ul>
                
                
                `;

                modal.find('.withdraw-details').html(html);

                modal.modal('show');
            })

        })
    
    
    </script>
    
@endpush

