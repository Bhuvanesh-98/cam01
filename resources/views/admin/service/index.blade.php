@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('All Services')</h1>
      
          
        
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
                        <form method="GET" action="{{route('admin.service.search')}}">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search">
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
                                <th>@changeLang('Name')</th>
                                <th>@changeLang('Status')</th>
                                <th>@changeLang('Action')</th>
                            </tr>
                            @forelse ($services as $key=>$service)
                                <tr>

                                    <td>{{ $key + $services->firstItem() }}</td>
                                    <td>{{ __($service->name) }}</td>
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

                                    @if ($service->admin_approval == 0)

                                        <button class="btn btn-primary accept" data-href="{{route('admin.service.accept',$service)}}">@changeLang('Accept')</button>
                                        <button class="btn btn-danger reject" data-href="{{route('admin.service.reject',$service)}}">@changeLang('Reject')</button>
                                        
                                    @endif

                                      <button class="btn btn-info userdata" data-service="{{ $service }}" data-duration="@switch($service->duration)
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

                                        @endswitch" data-review="{{number_format($service->reviews()->avg('review')) ?? 'Not Reviewed Yet'}}">@changeLang('Details')</button>
                                    
                                        <a target="_blank" href="{{route('admin.service.message',$service)}}" class="btn btn-primary">@changeLang('Reviews')</a>
                                       
                                        
                                    
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
                @if ($services->hasPages())
                    {{ $services->links('admin.partials.paginate') }}
                @endif
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
                            <h5 class="modal-title">@changeLang('Accept Service')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <p>@changeLang('Are You sure to accept this service')?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                    <button type="submit" class="btn btn-primary">@changeLang('Accept')</button>
                </div>
            </div>
            </form>
        </div>
    </div><!-- Modal -->

    <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form action="" method="post">
            @csrf
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">@changeLang('Reject Service')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="form-group col-md-12">

                            <label for="">@changeLang('Reason of Rejection')</label>
                            <textarea name="reason_of_reject" id="" cols="30" rows="5" class="form-control"></textarea>
                            
                            </div>
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                    <button type="submit" class="btn btn-danger">@changeLang('Reject')</button>
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
                        <h5 class="modal-title">@changeLang('Service Details')</h5>
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

            $('.accept').on('click',function(){
                const modal = $('#accept');

                modal.find('form').attr('action',$(this).data('href'));

                modal.modal('show');
            })
            $('.reject').on('click',function(){
                const modal = $('#reject');

                modal.find('form').attr('action',$(this).data('href'));

                modal.modal('show');
            })


            $('.userdata').on('click', function(e) {
                    e.preventDefault();

                    const modal = $('#confirm');

                    let service = $(this).data('service');
                    let review = $(this).data('review');
                    let duration = $(this).data('duration');
                   
                    let html = `
                
                                    <tr>
                                        <td>@changeLang('Provider Name')</td>
                                        <td>${service.user.fname+' '+service.user.lname}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>@changeLang('Service Rate')</td>
                                        <td>{{$general->currency_icon}} ${service.rate}</td>
                                    </tr> 
                                    
                                     <tr>
                                        <td>@changeLang('Service Category')</td>
                                        <td> ${service.category.name}</td>
                                    </tr>  
                                    
                                    <tr>
                                        <td>@changeLang('Service Duration')</td>
                                        <td>${duration}</td>
                                    </tr> 
                                    
                                    <tr>
                                        <td>@changeLang('Service Location')</td>
                                        <td>${service.location}</td>
                                    </tr> 
                                    
                                     <tr>
                                        <td>@changeLang('Service Rating')</td>
                                        <td>${review}</td>
                                    </tr> 
                                    
                
                
                
                `;

                    modal.find('.user-data').html(html);

                    modal.modal('show');

                })

        })
    
    
    </script>
    
@endpush

