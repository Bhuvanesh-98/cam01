@extends('frontend.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Dashboard')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

    @if (auth()->user()->user_type == 2)
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>@changeLang('My Balance')</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($balance, 2) . ' ' . $general->site_currency }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                       <i class="fas fa-toilet-paper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>@changeLang('Total Service')</h4>
                        </div>
                        <div class="card-body">
                            {{ $service }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                       <i class="far fa-check-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>@changeLang('Total Job Done')</h4>
                        </div>
                        <div class="card-body">
                            {{ $jobCompleted }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-star"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>@changeLang('My Ratings')</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($myRatings) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">
                        @changeLang('Booking Table')
                    </div>

                    <div class="card-body text-center">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>@changeLang('Sl')</th>
                                    <th>@changeLang('Service Name')</th>
                                    <th>@changeLang('Rate')</th>
                                    <th>@changeLang('Duration')</th>
                                    <th>@changeLang('Amount')</th>
                                    <th>@changeLang('status')</th>
                                    <th>@changeLang('Action')</th>
                                </tr>

                                @forelse ($bookings as $key=>$booking)
                                    <tr>
                                        <td>{{ $key + $bookings->firstItem() }}</td>
                                        <td>{{ @$booking->service->name }}</td>
                                        <td>{{ $general->currency_icon . '' . $booking->service->rate }}</td>
                                        <td>

                                            @switch($booking->service->duration)
                                                @case(0)
                                                    @changeLang('Hourly')
                                                @break
                                                @case(1)
                                                    @changeLang('Daily')
                                                @break
                                                @case(2)
                                                    @changeLang('Weekly')
                                                @break

                                                @case(3)
                                                    @changeLang('Monthly')
                                                @break

                                                @case(4)
                                                    @changeLang('Yearly')
                                                @break

                                                @default
                                                    @changeLang('Fixed')

                                            @endswitch


                                        </td>
                                        <td>{{ $general->currency_icon . '' . $booking->amount }}</td>
                                        <td>

                                            @if ($booking->is_completed)
                                                <span class="badge badge-success">@changeLang('Completed')</span>
                                            @elseif($booking->payment_confirmed == 1)
                                                <span class="badge badge-success">@changeLang('In Progress')</span>
                                            @elseif($booking->payment_confirmed == 2)
                                                <span class="badge badge-warning">@changeLang('Payment pending')</span>
                                            @elseif($booking->payment_confirmed == 3)
                                                <span class="badge badge-danger">@changeLang('Payment Rejected')</span>
                                            @elseif ($booking->is_accepted == 0)
                                                <span class="badge badge-warning">@changeLang('Pending')</span>
                                            @elseif ($booking->is_accepted == 1)
                                                <span class="badge badge-success">@changeLang('Accepted')</span>
                                            @elseif ($booking->is_accepted == 2)
                                                <span class="badge badge-danger">@changeLang('Rejected')</span>
                                            @endif


                                        </td>
                                        <td>
                                            @if ($booking->is_accepted == 0)
                                                <button class="btn btn-success accept"
                                                    data-url="{{ route('user.service.booking.accept', $booking) }}">@changeLang('Accept')</button>
                                                <button class="btn btn-danger reject"
                                                    data-url="{{ route('user.service.booking.reject', $booking) }}">@changeLang('Reject')</button>

                                            @endif

                                            @if ($booking->is_completed && $booking->job_end == 0)

                                                <button class="btn btn-primary contract"
                                                    data-url="{{ route('user.end.contract', $booking) }}">@changeLang('End Contract')</button>

                                            @endif


                                            @if ($booking->job_end == 0)

                                                <a class="btn btn-primary"
                                                    href="{{ route('user.chat', $booking->trx) }}">@changeLang('Chat')</a>
                                            @endif

                                            <button class="btn btn-info userdata" data-user="{{ $booking->user }}"
                                                data-booking="{{ $booking }}"
                                                data-hours="{{ $booking->hours . 'h' }}"
                                                data-date="{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}"
                                                data-service_date="{{ \Carbon\Carbon::parse($booking->service_date)->format('d F Y') }}">@changeLang('Details')</button>

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


                    </div>

                    @if($bookings->hasPages())
                        <div class="card-footer">
                            {{$bookings->links('frontend.partials.paginate')}}
                        </div>
                    @endif

                </div>

                <div class="col-md-12">

                    <div class="card">


                        <div class="card-header">

                            <h6>@changeLang('Service Table')</h6>

                        </div>


                        <div class="card-body text-center">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                    <th>@changeLang('Service Image')</th>
                                    <th>@changeLang('Name')</th>
                                    <th>@changeLang('Category')</th>
                                    <th>@changeLang('Rate')</th>
                                    <th>@changeLang('Duration')</th>
                                    <th>@changeLang('Status')</th>
                                    <th>@changeLang('Action')</th>
                                    </tr>
                                    @forelse ($services as $service)
                                <tr>

                                    <td>
                                    <img src="@if($service->service_image) {{getFile('service',$service->service_image)}} @else {{getFile('logo',$general->service_default_image)}} @endif" class="image-rounded">
                                    
                                    </td>
                                    <td>{{ __($service->name) }}</td>
                                    <td>{{ __($service->category->name) }}</td>
                                    <td>{{ __($general->currency_icon . '  ' . $service->rate) }}</td>
                                    <td>
                                        @switch($service->duration)
                                            @case(0)
                                                @changeLang('Hourly')
                                            @break
                                            @case(1)
                                                @changeLang('Daily')
                                            @break
                                            @case(2)
                                                @changeLang('Weekly')
                                            @break 
                                            
                                            @case(3)
                                                @changeLang('Monthly')
                                            @break
                                            
                                            @case(4)
                                                @changeLang('Yearly')
                                            @break

                                            @default
                                             @changeLang('Fixed')

                                        @endswitch
                                    </td>

                                    <td>

                                        @if($service->admin_approval == 0)


                                            <span class="badge badge-warning">@changeLang('Pending')</span> 
                                        @elseif($service->admin_approval == 2)


                                            <span class="badge badge-danger">@changeLang('Rejected')</span>

                                        @elseif($service->status)
                                            
                                            <span class="badge badge-success">@changeLang('Active')</span>

                                        @else
                                            <span class="badge badge-danger">@changeLang('Inactive')</span>

                                        @endif
                                    
                                    
                                    </td>

                                    <td>
                                    
                                        <a href="{{route('user.service.edit',$service)}}" class="btn btn-primary"><i class="fa fa-pen"></i></a>

                                        <button data-href="{{route('user.service.delete',$service)}}" class="btn btn-danger delete"><i class="fa fa-trash"></i></button>
                                    
                                    
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


                            @if($services->hasPages())

                                <div class="card-footer">
                                
                                    {{ $services->links('frontend.partials.paginate') }}
                                
                                </div>

                            @endif






                        </div>


                    </div>


                </div>


                </div>





                <!-- Modal -->
                <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <p class="alert-text">@changeLang('Are you Sure To Accept This Booking')</p>
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


                <!-- Modal -->
                <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">@changeLang('User Details')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <table class="user-data table table-bordered p-0">




                                            </table>
                                        </div>



                                    </div>



                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">

                        <form action="" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">@changeLang('Delete Service')</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <p>@changeLang('Are You sure to delete this service')?</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                                    <button type="submit" class="btn btn-danger">@changeLang('Delete')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            @else



                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                               <i class="fas fa-toilet-paper"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>@changeLang('Total Bookings')</h4>
                                </div>
                                <div class="card-body">
                                    {{ $booking }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-spinner"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>@changeLang('Total Pending Bookings')</h4>
                                </div>
                                <div class="card-body">
                                    {{ $bookingPending }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                               <i class="far fa-check-circle"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>@changeLang('Total Bookings Completed')</h4>
                                </div>
                                <div class="card-body">
                                    {{ $bookingComplete }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                 <i class="fas fa-money-bill"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>@changeLang('Transaction Amount')</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalTransaction .' '. $general->site_currency }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <div class="card">


                            <div class="card-body text-center">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                           
                                            <th>@changeLang('Service Name')</th>
                                            <th>@changeLang('Rate')</th>
                                            <th>@changeLang('Duration')</th>
                                            <th>@changeLang('Amount')</th>
                                            <th>@changeLang('status')</th>
                                            <th>@changeLang('Action')</th>
                                        </tr>

                                        @forelse ($bookings as $key => $booking)
                                            <tr>
                                               
                                                <td>{{ @$booking->service->name }}</td>

                                                <td>{{ $general->currency_icon . '' . $booking->service->rate }}</td>
                                                <td>

                                                    @switch($booking->service->duration)
                                                        @case(0)
                                                            @changeLang('Hourly')
                                                        @break
                                                        @case(1)
                                                            @changeLang('Daily')
                                                        @break
                                                        @case(2)
                                                            @changeLang('Weekly')
                                                        @break

                                                        @case(3)
                                                            @changeLang('Monthly')
                                                        @break

                                                        @case(4)
                                                            @changeLang('Yearly')
                                                        @break

                                                        @default
                                                            @changeLang('Fixed')

                                                    @endswitch


                                                </td>
                                                <td>{{ $general->currency_icon . '' . $booking->amount }}</td>
                                                <td>
                                                    @if ($booking->is_completed)
                                                        <span class="badge badge-success">@changeLang('Completed')</span>
                                                    @elseif($booking->payment_confirmed == 1)
                                                        <span class="badge badge-success">@changeLang('In Progress')</span>
                                                    @elseif($booking->payment_confirmed == 2)
                                                        <span class="badge badge-warning">@changeLang('Payment pending')</span>

                                                    @elseif($booking->payment_confirmed == 3)
                                                        <span class="badge badge-danger">@changeLang('Payment Rejected')</span>
                                                    @elseif ($booking->is_accepted == 0)
                                                        <span class="badge badge-warning">@changeLang('Pending')</span>
                                                    @elseif ($booking->is_accepted == 1)
                                                        <span class="badge badge-success">@changeLang('Accepted')</span>

                                                    @elseif ($booking->is_accepted == 2)
                                                        <span class="badge badge-danger">@changeLang('Rejected')</span>
                                                    @endif



                                                </td>
                                                <td>

                                                    @if ($booking->is_accepted == 1 && $booking->payment_confirmed == 0 && $booking->is_completed == 0)

                                                        <a href="{{ route('user.pay.bill', $booking) }}"
                                                            class="btn btn-primary">@changeLang('Pay Bill')</a>

                                                    @endif

                                                    @if ($booking->is_accepted && $booking->is_completed == 0 && $booking->payment_confirmed == 1)
                                                        <button class="btn btn-primary complete"
                                                            data-url="{{ route('user.bookings.complete', $booking) }}">@changeLang('Mark As Complete')</button>
                                                    @endif
                                                    @if ($booking->job_end == 0)
                                                        <a class="btn btn-primary"
                                                            href="{{ route('user.chat.provider', $booking->trx) }}">@changeLang('Chat')</a>
                                                    @endif
                                                    <button class="btn btn-info userdata" data-user="{{ $booking->user }}"
                                                        data-booking="{{ $booking }}"
                                                        data-hours="{{ $booking->hours . 'h' }}"
                                                        data-date="{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}"
                                                        data-service_date="{{ \Carbon\Carbon::parse($booking->service_date)->format('d F Y') }}">@changeLang('Details')</button>

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

                            @if ($bookings->hasPages())

                            <div class="card-footer">

                                {{$bookings->links('frontend.partials.paginate')}}
                            
                            </div>
                                
                            @endif



                        </div>

                    </div>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="complete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">@changeLang('Complete Service Booking')</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <p>@changeLang('Are You sure to make the booking completed')?</p>
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


                <!-- Modal -->
                <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">@changeLang('Booking Details')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <table class="user-data table table-bordered p-0">




                                            </table>
                                        </div>



                                    </div>



                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                            </div>
                        </div>
                    </div>
                </div>




            @endif





        @endsection

        @push('custom-style')

            <style>
                .font-25 {
                    font-size: 25px;
                }

            </style>

        @endpush


        @push('custom-script')

            <script>
                $(function() {
                    'use strict'

                    $('.complete').on('click', function() {
                        const modal = $('#complete');
                        modal.find('form').attr('action', $(this).data('url'))
                        modal.modal('show');
                    })
                })
            </script>

        @endpush


        @push('custom-script')
            <script>
                $(function() {
                    'use strict'

                    $('.accept').on('click', function(e) {
                        e.preventDefault();

                        const modal = $('#modelId');

                        modal.find('.alert-text').text('Are you sure to accept this booking ?');

                        modal.find('.modal-title').text('Accept Booking');

                        modal.find('form').attr('action', $(this).data('url'));

                        modal.modal('show');

                    })

                    $('.reject').on('click', function(e) {
                        e.preventDefault();

                        const modal = $('#modelId');

                        modal.find('.alert-text').text("@changeLang('Are you sure to reject this booking')?");

                        modal.find('.modal-title').text("@changeLang('Reject Booking')");

                        modal.find('form').attr('action', $(this).data('url'));

                        modal.modal('show');

                    })

                    $('.delete').on('click', function() {
                        const modal = $('#delete');

                        modal.find('form').attr('action', $(this).data('href'));

                        modal.modal('show');
                    })

                    $('.userdata').on('click', function(e) {
                        e.preventDefault();

                        const modal = $('#confirm');

                        let user = $(this).data('user');
                        let booking = $(this).data('booking');

                        let userAddress = '';

                        user.address != null ? userAddress = user.address.address : '';



                        let html = `
                
                                    <tr>
                                        <td>@changeLang('Booking Id')</td>
                                        <td>${booking.trx}</td>
                                    </tr> 
                                    <tr>
                                        <td>@changeLang('Total Hours')</td>
                                        <td>${$(this).data('hours')}</td>
                                    </tr>  
                                    
                                    <tr>
                                        <td>@changeLang('Service Date')</td>
                                        <td>${new Date(booking.service_date).toDateString()}</td>
                                    </tr>

                                    <tr>
                                        <td>@changeLang('End Date')</td>
                                        <td>${new Date(booking.end_date).toDateString()}</td>
                                    </tr> 
                                   
                                    <tr>
                                        <td>@changeLang('Service Location')</td>
                                        <td>${booking.location}</td>
                                    </tr> 
                                    
                                    <tr>
                                        <td>@changeLang('Booking Time')</td>
                                        <td>${$(this).data('date')}</td>
                                    </tr> 
                                    
                                    <tr>
                                        <td>@changeLang('User Name')</td>
                                        <td>${user.fname +' '+ user.lname}</td>
                                    </tr> 
                                    
                                    <tr>
                                        <td>@changeLang('Mobile Number')</td>
                                        <td>${user.mobile ?? 'N/A'}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>@changeLang('Email')</td>
                                        <td>${user.email}</td>
                                    </tr> 
                                    
                                    <tr>
                                        <td>@changeLang('Address')</td>
                                        <td>${userAddress ?? 'N/A'}</td>
                                    </tr>  
                                    
                                    <tr>
                                        <td>@changeLang('City')</td>
                                        <td>${user.address.city ?? 'N/A'}</td>
                                    </tr>  
                                    
                                    <tr>
                                        <td>@changeLang('Zip')</td>
                                        <td>${user.address.zip ?? 'N/A'}</td>
                                    </tr>  
                                    
                                    <tr>
                                        <td>@changeLang('Country')</td>
                                        <td>${user.address.country ?? 'N/A'}</td>
                                    </tr> 
                                    
                                   
                                    <tr>
                                        <td>@changeLang('Message')</td>
                                        <td>${booking.message}</td>
                                    </tr>
                                   
                
                
                
                `;

                        modal.find('.user-data').html(html);

                        modal.modal('show');

                    })

                    $('.contract').on('click', function(e) {
                    e.preventDefault();

                    const modal = $('#modelId');

                    modal.find('.alert-text').text("@changeLang('Are you sure to end this contract')?");

                    modal.find('.modal-title').text("@changeLang('Request admin to end contract')");

                    modal.find('form').attr('action', $(this).data('url'));

                    modal.modal('show');

                })


                })
            </script>
        @endpush
