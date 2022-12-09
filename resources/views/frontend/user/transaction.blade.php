@extends('frontend.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('All Transactions')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')


 <div class="row">

         <div class="col-md-12">

             <div class="card">

                 </div>


                 <div class="card-body p-0">
                     <div class="table-responsive">
                         <table class="table table-striped">
                             <thead>
                                 <tr>

                                     <th>@changeLang('Sl')</th>
                                     <th>@changeLang('Transaction Id')</th>
                                     <th>@changeLang('Name')</th>
                                    
                                     <th>@changeLang('Total Amount')</th>
                                     <th>@changeLang('Charge')</th>
                                     <th>@changeLang('Details')</th>
                                     <th>@changeLang('Date')</th>

                                 </tr>

                             </thead>

                             <tbody>

                                 @forelse($transactions as $key => $transaction)

                                        <tr>
                                        
                                            <td>{{$key + $transactions->firstItem()}}</td>
                                            <td>{{$transaction->gateway_transaction ?? $transaction->trx}}</td>
                                            <td>

                                                {{$transaction->user->fullname}}

                                            </td>

                                            <td>

                                                {{$transaction->amount.' '.$transaction->currency}}
                                            
                                            </td>
                                            <td>

                                                {{$transaction->charge.' '.$transaction->currency}}
                                            
                                            </td>
                                            
                                            <td>

                                                {{$transaction->details}}
                                            
                                            </td>


                                            <td>

                                                {{$transaction->created_at->format('d F Y')}}
                                            
                                            </td>
                                        
                                        </tr>
                                    
                                 @empty


                                     <tr>

                                         <td class="text-center" colspan="100%">@changeLang('No Data Found')</td>

                                     </tr>



                                 @endforelse



                             </tbody>
                         </table>
                     </div>
                 </div>


                 @if ($transactions->hasPages())

                 <div class="card-footer">
                 
                    {{ $transactions->links('frontend.partials.paginate') }}
                 
                 </div>
                     
                 @endif


             </div>



         </div>


     </div>


@endsection