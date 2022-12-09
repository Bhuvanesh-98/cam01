@extends('frontend.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Service Schedules')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')
@if (auth()->user()->services()->count() == 0)
    
    <div class="row">

        <div class="col-md-12">

            <p class="alert alert-warning">
            @changeLang('Please Create Service Also, Otherwise your profile will not shown')</p>
        
        </div>
    
    </div>
@endif

<div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <h4>

                        <a href="" class="btn btn-primary schedule"><i class="fa fa-plus"></i>
                            @changeLang('Create Schedule')</a>
                    </h4>

                </div>
                <div class="card-body text-center">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>@changeLang('Sl')</th>
                                <th>@changeLang('Day Name')</th>
                                <th>@changeLang('Time')</th>
                                <th>@changeLang('Status')</th>
                                <th>@changeLang('Action')</th>
                            </tr>

                        @forelse ($weeks as $key => $week)
                            
                            <tr>

                                <td>{{$key + $weeks->firstItem()}}</td>
                                <td>{{$week->week_name}}</td>
                                <td>{{\Carbon\Carbon::parse($week->start_time)->format('h:i A')  .' - '. \Carbon\Carbon::parse($week->end_time)->format('h:i A')}}</td>
                                <td>

                                    @if($week->status)
                                     <span class="badge badge-success">@changeLang('Active')</span>
                                    @else
                                     <span class="badge badge-danger">@changeLang('Inactive')</span>

                                    @endif
                                
                                
                                </td>

                                <td>

                                    <a href="javascript:void(0)" class="btn btn-primary edit" data-resource ="{{$week}}" data-start="{{\Carbon\Carbon::parse($week->start_time)->format('h:i A')}}" data-end="{{\Carbon\Carbon::parse($week->end_time)->format('h:i A')}}" data-url="{{route('user.service.schedule.update', $week)}}"><i class="fa fa-pen"></i></a>
                                
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

                @if ($weeks->hasPages())
                    <div class="card-footer">
                        {{$weeks->links('admin.partials.paginate')}}
                    </div>
                @endif
            </div>
        </div>
    </div>


    <div class="modal fade" id="schedule" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                        <div class="form-group">
                        
                        <label for="">@changeLang('Day Name')</label>
                        <select name="weekname" id="" class="form-control">

                            <option value="Saturday">@changeLang('Saturday')</option>
                            <option value="Sunday">@changeLang('Sunday')</option>
                            <option value="Monday">@changeLang('Monday')</option>
                            <option value="Tuesday">@changeLang('Tuesday')</option>
                            <option value="Wednesday">@changeLang('Wednesday')</option>
                            <option value="Thursday">@changeLang('Thursday')</option>
                            <option value="Friday">@changeLang('Friday')</option>
                        
                        </select>
                        
                        </div>

                        <div class="form-group">

                            <label for="">@changeLang('Start Time')</label>
                            <input type="text" name="start_time" class="form-control timepicker" autocomplete="off">
                        
                        </div>
                        
                        <div class="form-group">

                            <label for="">@changeLang('End Time')</label>
                            <input type="text" name="end_time" class="form-control timepicker" autocomplete="off">
                        
                        </div>

                        <div class="form-group">
                        
                        <label for="">@changeLang('Status')</label>
                        <select name="status" id="" class="form-control">

                            <option value="1">@changeLang('Active')</option>
                            <option value="0">@changeLang('Inactive')</option>
                            
                        
                        </select>
                        
                        </div>
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
    

@endsection


@push('custom-script')

    <script>
    
        $(function(){
            'use strict'

            $('.schedule').on('click',function(e){
                e.preventDefault();
                const modal = $('#schedule');

                 modal.find('.modal-title').text("@changeLang('Add Schedule')")
                 modal.find('form').attr('action','');

                modal.modal('show')
            })

            $('.edit').on('click',function(e){
                e.preventDefault();

                const data = $(this).data('resource');

                const start = $(this).data('start');
                const end = $(this).data('end');

                const modal = $('#schedule');

                modal.find('.modal-title').text("@changeLang('Update Schedule')")

                modal.find('select[name="weekname"]').val(data.week_name);
                modal.find('select[name="status"]').val(data.status);

                modal.find('input[name=start_time]').val(start);
                modal.find('input[name=end_time]').val(end);

                modal.find('form').attr('action',$(this).data('url'));

                modal.modal('show')

            })
        })
    
    
    </script>
    
@endpush