@extends('admin.layout.master')

@section('breadcrumb')
 <section class="section">
          <div class="section-header">
          @if (request()->routeIs('admin.bookings'))
            <h1>@changeLang('All Bookings')</h1>
          @elseif (request()->routeIs('admin.bookings.completed'))
            <h1>@changeLang('Complete Bookings')</h1>
          @elseif (request()->routeIs('admin.bookings.incomplete'))
            <h1>@changeLang('Incomplete Bookings')</h1> 
          @elseif (request()->routeIs('admin.bookings.end.job'))
            <h1>@changeLang('End Bookings')</h1>
          @endif
          </div>
</section>
@endsection

@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <h4>
                    </h4>

                    <div class="card-header-form">
                        <form method="GET" action="{{ route('admin.bookings.search') }}">
                            <div class="input-group">
                                <input type="text" class="form-control"  name="search">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

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
                                <th>@changeLang('Status')</th>
                                <th>@changeLang('Action')</th>
                            </tr>

                            @forelse ($bookings as $key=> $booking )
                                <tr>
                                <td>{{ $key + $bookings->firstItem() }}</td>
                                <td>{{@$booking->service->name}}</td>
                                <td>{{$general->currency_icon .''. $booking->service->rate}}</td>
                                <td>
                                
                                     @switch(@$booking->service->duration)
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
                                <td>{{$general->currency_icon .''. $booking->amount}}</td>
                                <td>
                                    @if($booking->is_completed)
                                            <span class="badge badge-success">@changeLang('Completed')</span>
                                    @elseif($booking->payment_confirmed == 1)
                                         <span class="badge badge-success">@changeLang('In Progress')</span>
                                    @elseif($booking->payment_confirmed == 2)
                                        <button  class="btn btn-warning" >@changeLang('Payment pending')</button>
                                    @elseif ($booking->is_accepted == 0)
                                        <span class="badge badge-warning">@changeLang('Pending')</span>
                                    @elseif ($booking->is_accepted == 1)
                                        <span class="badge badge-success">@changeLang('Accepted')</span>
                                    @elseif ($booking->is_accepted == 2)
                                        <span class="badge badge-danger">@changeLang('Rejected')</span>
                                    @endif

                                
                                
                                </td>
                                <td>

                                   @if($booking->payment_confirmed == 1  && $booking->is_accepted && $booking->is_completed == 0)
                                       <button class="btn btn-primary complete" data-url="{{route('admin.bookings.complete', $booking)}}">@changeLang('Complete')</button>
                                   
                                    @endif

                                    @if($booking->job_end == 2)

                                            <button class="btn btn-info contract" data-url="{{route('admin.bookings.end.contract', $booking)}}">@changeLang('End Contract')</button>

                                    @endif

                                     <button class="btn btn-info userdata" data-user="{{ $booking->user }}"
                                            data-booking="{{ $booking }}" data-hours="{{ $booking->hours . 'h' }}" data-date="{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}" data-service_date="{{\Carbon\Carbon::parse($booking->service_date)->format('d F Y')}}">@changeLang('Details')</button>

                                    <button class="btn btn-danger delete" data-url="{{route('admin.bookings.delete', $booking)}}">@changeLang('Delete')</button>
                               
                              
                                
                                </td>
                            </tr>
                            @empty

                                <tr>
                                
                                    <td class="text-center" colspan="100%" >@changeLang('No Bookings Found')</td>
                                
                                </tr>


                            @endforelse
                        </table>
                    </div>
                </div>
                @if($bookings->hasPages())
                    <div class="card-footer">
                        {{$bookings->links('admin.partials.paginate')}}
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
    </div><!-- Modal -->

    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="post">
            @csrf
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">@changeLang('Delete Service Booking')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                       <p>@changeLang('Are You sure to delete Booking')?</p>
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
    
    <div class="modal fade" id="contract" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="post">
            @csrf
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">@changeLang('End Contract For a Service')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                       <p>@changeLang('Are You sure to end this job')?</p>
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

@endsection


@push('custom-script')

<script>

    $(function(){
        'use strict'

        $('.complete').on('click', function(){
            const modal = $('#complete');
            modal.find('form').attr('action', $(this).data('url'))
            modal.modal('show');
        })
        $('.delete').on('click', function(){
            const modal = $('#delete');
            modal.find('form').attr('action', $(this).data('url'))
            modal.modal('show');
        })
        
        $('.contract').on('click', function(){
            const modal = $('#contract');
            modal.find('form').attr('action', $(this).data('url'))
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
                                        <td>@changeLang('Booking id')</td>
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
                                        <td>@changeLang('Service Message For Service Provider')</td>
                                        <td>${booking.message}</td>
                                    </tr>
                                   
                
                
                
                `;

                    modal.find('.user-data').html(html);

                    modal.modal('show');

                })
    })


</script>
    
@endpush