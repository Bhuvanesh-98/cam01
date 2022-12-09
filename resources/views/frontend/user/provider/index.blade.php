@extends('frontend.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('All Services')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

@if (auth()->user()->schedules()->count() == 0)
    
    <div class="row">

        <div class="col-md-12">

            <p class="alert alert-warning">@changeLang('Please Create Schedule Also, Otherwise your profile will not shown')</p>
        
        </div>
    
    </div>
@endif

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <h4>

                        <a href="{{ route('user.service.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                            @changeLang('Create Service')</a>

                    </h4>
                    
                    <div class="card-header-form">
                        <form method="GET" action="{{route('user.service.search')}}">
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
                @if ($services->hasPages())
                    {{ $services->links('admin.partials.paginate') }}
                @endif
            </div>
        </div>
    </div>


    
    <!-- Modal -->
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
    


@endsection


@push('custom-script')

    <script>
    
        $(function(){
            'use strict'

            $('.delete').on('click',function(){
                const modal = $('#delete');

                modal.find('form').attr('action',$(this).data('href'));

                modal.modal('show');
            })

        })
    
    
    </script>
    
@endpush

