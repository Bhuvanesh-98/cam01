@extends('admin.layout.master')
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

                 <div class="card-header">
                    <h4></h4>

                     <div class="card-header-form">
                         <form method="GET" action="">
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
                             <thead>
                                 <tr>

                                     <th>@changeLang('Sl')</th>
                                     <th>@changeLang('Transaction Id')</th>
                                     <th>@changeLang('Name')</th>
                                     <th>@changeLang('User Type')</th>
                                     <th>@changeLang('Amount')</th>
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

                                                @if($transaction->user->user_type == 2)
                                                    <span class="badge badge-primary">@changeLang('Provider')</span>
                                                @else
                                                    <span class="badge badge-primary">@changeLang('user')</span>
                                                @endif
                                            
                                            
                                            </td>

                                            <td>

                                                {{$transaction->amount.' '.$transaction->currency}}
                                            
                                            </td>
                                            <td>

                                                {{number_format($transaction->charge,4).' '.$transaction->currency}}
                                            
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

                                         <td class="text-center" colspan="100%">@changeLang('No Providers Found')</td>

                                     </tr>



                                 @endforelse



                             </tbody>
                         </table>
                     </div>
                 </div>


                 @if($transactions->hasPages())

                    <div class="card-footer">

                        {{ $transactions->links('admin.partials.paginate') }}

                    </div>

                 @endif


             </div>



         </div>


     </div>


@endsection