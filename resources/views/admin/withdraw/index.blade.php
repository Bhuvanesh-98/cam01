@extends('admin.layout.master')

@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Withdraw Methods')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')


    <div class="row">

        <div class="col-md-12">

            <div class="card">
                <div class="card-header">

                    <h4>

                        <button class="btn btn-primary add"><i
                                class="fa fa-plus"></i>
                            @changeLang('Add Withdraw Method')</button>
                    </h4>
                    <div class="card-header-form">
                        <form method="GET" action="{{ route('admin.withdraw.search') }}">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>



                </div>
                <div class="card-body">

                    <div class="card-body text-center">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>@changeLang('Sl')</th>
                                    <th>@changeLang('Name')</th>
                                    <th>@changeLang('Charge')</th>
                                    <th>@changeLang('Charge Type')</th>
                                    <th>@changeLang('Min Withdraw')</th>
                                    <th>@changeLang('Max Withdraw')</th>
                                    <th>@changeLang('status')</th>
                                    <th>@changeLang('Action')</th>
                                </tr>
                                @forelse ($withdraws as $key => $withdraw)
                                    <tr>

                                        <td>{{$key +  $withdraws->firstItem() }}</td>
                                        <td>{{ $withdraw->name }}</td>
                                        <td>{{ number_format($withdraw->charge,2) }}</td>
                                        <td>{{ ucwords($withdraw->charge_type) }}</td>
                                        <td>{{ $withdraw->min_withdraw }}</td>
                                        <td>{{ $withdraw->max_withdraw }}</td>

                                        <td>
                                            @if ($withdraw->status)
                                                <div class="badge badge-success">@changeLang('Active')</div>
                                            @else
                                                <div class="badge badge-danger">@changeLang('Inactive')</div>
                                            @endif
                                        </td>
                                        <td>

                                            <button data-href="{{ route('admin.withdraw.update', $withdraw) }}" data-withdraw="{{$withdraw}}"
                                                class="btn btn-primary update"><i class="fa fa-pen"></i></button>
                                            <button data-url="{{ route('admin.withdraw.delete', $withdraw) }}"
                                                class="btn btn-danger delete"><i class="fa fa-trash"></i></button>

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
                    @if ($withdraws->hasPages())
                        <div class="card-footer">
                            {{ $withdraws->links('admin.partials.paginate') }}
                        </div>
                    @endif


                </div>




            </div>



        </div>



    </div>




    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
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
                            <div class="row">
                            
                                <div class="form-group col-md-6 col-12">

                                    <label for="">@changeLang('Withdraw Method Name') <span class="text-danger">*</span> </label>
                                    <input type="text" name="name" class="form-control">
                                
                                </div> 
                                
                                <div class="form-group col-md-6 col-12">

                                    <label for="">@changeLang('Withdraw Method charge Type')</label>
                                    <select name="charge_type" class="form-control">
                                        <option value="fixed">@changeLang('Fixed')</option>
                                        <option value="percent">@changeLang('Percent')</option>
                                    </select>
                                
                                </div> 
                                
                                <div class="form-group col-md-6 col-12">

                                    <label for="">@changeLang('Withdraw Method charge')</label>
                                    <input type="text" name="charge" class="form-control" required>
                                
                                </div>  
                                
                                <div class="form-group col-md-6 col-12">

                                    <label for="">@changeLang('Withdraw Min Amount')</label>
                                    <input type="text" name="min_amount" class="form-control">
                                
                                </div> 
                                
                                <div class="form-group col-md-6 col-12">

                                    <label for="">@changeLang('Withdraw Max Amount')</label>
                                    <input type="text" name="max_amount" class="form-control">
                                
                                </div> 
 
                                 <div class="form-group col-md-6 col-12">

                                    <label for="">@changeLang('Withdraw Method status')</label>
                                    <select name="status" class="form-control">
                                        <option value="0">@changeLang('Inactive')</option>
                                        <option value="1">@changeLang('Active')</option>
                                    </select>
                                
                                </div> 
                                
                                <div class="form-group col-md-12">

                                    <label for="">@changeLang('Withdraw Instruction')</label>
                                    <textarea name="withdraw_instruction" id="" cols="30" rows="10" class="form-control summernote">{{old('withdraw_instruction')}}</textarea>
                                
                                </div>

                                  
                               
                            
                            
                            
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


    
    <!-- Modal -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="post">
             @csrf
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">@changeLang('Delete Withdraw Method')</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <p>@changeLang('Are you sure to delete this method')?</p>
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
        $(function() {
            'use strict'

            $('.add').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("@changeLang('Create Withdraw Method')")
                modal.find('input[name=name]').val('')
                modal.find('input[name=charge]').val('')
                modal.find('input[name=min_amount]').val('')
                modal.find('input[name=max_amount]').val('')
                modal.find('textarea[name=withdraw_instruction]').val('')
                modal.find('form').attr('action','');
           

                modal.modal('show');
            }) 
            
            $('.update').on('click', function() {
                const modal = $('#modelId');

                

                modal.find('.modal-title').text("@changeLang('Update Withdraw Method')")
                modal.find('input[name=name]').val($(this).data('withdraw').name)
                modal.find('input[name=charge]').val($(this).data('withdraw').charge)
                modal.find('input[name=min_amount]').val($(this).data('withdraw').min_withdraw)
                modal.find('input[name=max_amount]').val($(this).data('withdraw').max_withdraw)
                modal.find('select[name=status]').val($(this).data('withdraw').status)
                modal.find('select[name=charge_type]').val($(this).data('withdraw').charge_type)
                modal.find('textarea[name=withdraw_instruction]').val($(this).data('withdraw').withdraw_instruction)
                modal.find('form').attr('action',$(this).data('href'));

               $('.summernote').summernote('code', $(this).data('withdraw').withdraw_instruction)
                modal.modal('show');
            })

             $('.delete').on('click', function() {
                const modal = $('#delete');
                modal.find('form').attr('action',$(this).data('url'));

                modal.modal('show');
             })
        })
    </script>

@endpush
