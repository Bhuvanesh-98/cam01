 @extends('admin.layout.master')
  @section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Dashboard')</h1>
        
          </div>
</section>
@endsection
 @section('content')

     <div class="row">
         <div class="col-lg-3 col-md-6 col-sm-6 col-12">
             <div class="card card-statistic-1">
                 <div class="card-icon bg-primary">
                     <i class="far fa-user"></i>
                 </div>
                 <div class="card-wrap">
                     <div class="card-header">
                         <h4>@changeLang('Total User')</h4>
                     </div>
                     <div class="card-body">
                         {{ $totalUser }}
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6 col-12">
             <div class="card card-statistic-1">
                 <div class="card-icon bg-info">
                     <i class="fas fa-person-booth"></i>
                 </div>
                 <div class="card-wrap">
                     <div class="card-header">
                         <h4>@changeLang('Total Provider')</h4>
                     </div>
                     <div class="card-body">
                         {{ $totalProvider }}
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6 col-12">
             <div class="card card-statistic-1">
                 <div class="card-icon bg-warning">
                     <i class="fas fa-toilet-paper"></i>
                 </div>
                 <div class="card-wrap">
                     <div class="card-header">
                         <h4>@changeLang('Total Service')</h4>
                     </div>
                     <div class="card-body">
                         {{ $totalService }}
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6 col-12">
             <div class="card card-statistic-1">
                 <div class="card-icon bg-success">
                    <i class="fas fa-th-list"></i>
                 </div>
                 <div class="card-wrap">
                     <div class="card-header">
                         <h4>@changeLang('Total Category')</h4>
                     </div>
                     <div class="card-body">
                         {{ $totalCategory }}
                     </div>
                 </div>
             </div>
         </div>
     </div>


     <div class="row">

         <div class="col-12 col-md-6 col-lg-6">
             <div class="card">
                 <div class="card-header">
                     <h4>@changeLang('Payment Statistics')</h4>
                 </div>
                 <div class="card-body">
                     <canvas id="myChart2"></canvas>
                 </div>
             </div>
         </div>

         <div class="col-12 col-md-6 col-lg-6">
             <div class="card">
                 <div class="card-header">
                     <h4>@changeLang('Withdraw Statistics')</h4>
                 </div>
                 <div class="card-body">
                     <canvas id="myChart"></canvas>
                 </div>
             </div>
         </div>

     </div>

     <div class="row">

         <div class="col-md-12">

             <div class="card">


                <div class="card-header">

                  <h6>@changeLang('Provider Table')</h6>

                </div>


                     <div class="card-body p-0">
                         <div class="table-responsive">
                             <table class="table table-striped">
                                 <thead>
                                     <tr>

                                         <th>@changeLang('Sl')</th>
                                         <th>@changeLang('Full Name')</th>
                                         <th>@changeLang('Username')</th>
                                         <th>@changeLang('Phone')</th>
                                         <th>@changeLang('Email')</th>
                                         <th>@changeLang('Country')</th>
                                         <th>@changeLang('Status')</th>
                                         <th>@changeLang('Action')</th>

                                     </tr>

                                 </thead>

                                 <tbody>

                                     @forelse($providers as $key=>$provider)

                                         <tr>

                                             <td>{{$key + $providers->firstItem() }}</td>
                                             <td>{{ __($provider->fullname) }}</td>
                                             <td>{{ __($provider->username) }}</td>
                                             <td>{{ __($provider->mobile) }}</td>
                                             <td>{{ __($provider->email) }}</td>
                                             <td>{{ __(@$provider->address->country) }}</td>
                                             <td>

                                                 @if ($provider->status) <span
                                                     class='badge badge-success'>@changeLang('Active')</span> @else <span
                                                         class='badge badge-danger'>@changeLang('Inactive')</span> @endif

                                             </td>

                                             <td>

                                                 <a href="{{ route('admin.provider.details', $provider) }}"
                                                     class="btn btn-primary"><i class="fa fa-pen"></i></a>


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


                     @if($providers->hasPages())

                        <div class="card-footer">
                        
                            {{ $providers->links('admin.partials.paginate') }}
                        </div>

                     @endif



                 


             </div>


         </div>


     </div>
     
     <div class="row">

         <div class="col-md-12">

             <div class="card">


                <div class="card-header">

                  <h6>@changeLang('User Table')</h6>

                </div>


                     <div class="card-body p-0">
                         <div class="table-responsive">
                             <table class="table table-striped">
                                 <thead>
                                     <tr>

                                         <th>@changeLang('Sl')</th>
                                         <th>@changeLang('Full Name')</th>
                                         <th>@changeLang('Username')</th>
                                         <th>@changeLang('Phone')</th>
                                         <th>@changeLang('Email')</th>
                                         <th>@changeLang('Country')</th>
                                         <th>@changeLang('Status')</th>
                                         <th>@changeLang('Action')</th>

                                     </tr>

                                 </thead>

                                 <tbody>

                                     @forelse($users as $key => $user)

                                         <tr>

                                             <td>{{ $key + $users->firstItem() }}</td>
                                             <td>{{ __($user->fullname) }}</td>
                                             <td>{{ __($user->username) }}</td>
                                             <td>{{ __($user->mobile) }}</td>
                                             <td>{{ __($user->email) }}</td>
                                             <td>{{ __(@$user->address->country) }}</td>
                                             <td>

                                                 @if ($user->status) <span
                                                     class='badge badge-success'>@changeLang('Active')</span> @else <span
                                                         class='badge badge-danger'>@changeLang('Inactive')</span> @endif

                                             </td>

                                             <td>

                                                 <a href=""
                                                     class="btn btn-primary"><i class="fa fa-pen"></i></a>


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

                    @if($users->hasPages())
                     <div class="card-footer">
                        {{ $users->links('admin.partials.paginate') }}
                     </div>
                    @endif


                 


             </div>


         </div>


     </div>



 @endsection


 @push('custom-script')

     <script>
         

         var ctx = document.getElementById("myChart2").getContext('2d');
         var myChart = new Chart(ctx, {
             type: 'bar',
             data: {
                 labels: @json($payment['months']->flatten()),
                 datasets: [{
                     label: 'Statistics',
                     data: [
                         @foreach($payment['months'] as $month)
                            {{ number_format(@$depositsMonth->where('months',$month)->first()->payments,2, '.', '') }},
                            @endforeach
                      ],
                     borderWidth: 2,
                     backgroundColor: '#6777ef',
                     borderColor: '#6777ef',
                     borderWidth: 2.5,
                     pointBackgroundColor: '#ffffff',
                     pointRadius: 4
                 }]
             },
             options: {
                 legend: {
                     display: false
                 },
                 scales: {
                     yAxes: [{
                         gridLines: {
                             drawBorder: false,
                             color: '#f2f2f2',
                         },
                         ticks: {
                             beginAtZero: true,
                             stepSize: 150
                         }
                     }],
                     xAxes: [{
                         ticks: {
                             display: false
                         },
                         gridLines: {
                             display: false
                         }
                     }]
                 },
             }
         });

         var ctx2 = document.getElementById("myChart").getContext('2d');
         var myChart2 = new Chart(ctx2, {
             type: 'bar',
             data: {
                 labels:  @json($payment['months']->flatten()),
                 datasets: [{
                     label: 'Statistics',
                     data: [ @foreach($payment['months'] as $month)
                        {{ number_format(@$withdrawalMonth->where('months',$month)->first()->withdrawAmount,2, '.', '') }},
                      @endforeach],
                     borderWidth: 2,
                     backgroundColor: '#6777ef',
                     borderColor: '#6777ef',
                     borderWidth: 2.5,
                     pointBackgroundColor: '#ffffff',
                     pointRadius: 4
                 }]
             },
             options: {
                 legend: {
                     display: false
                 },
                 scales: {
                     yAxes: [{
                         gridLines: {
                             drawBorder: false,
                             color: '#f2f2f2',
                         },
                         ticks: {
                             beginAtZero: true,
                             stepSize: 150
                         }
                     }],
                     xAxes: [{
                         ticks: {
                             display: false
                         },
                         gridLines: {
                             display: false
                         }
                     }]
                 },
             }
         });
     </script>

 @endpush
