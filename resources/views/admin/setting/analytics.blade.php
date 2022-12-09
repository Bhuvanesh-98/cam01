@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Manage Analytics')</h1>
      
          
        
          </div>
</section>
@endsection

@section('content')


    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <div class="form-group col-md-6 mb-3">
                                <label class="col-form-label">@changeLang('Analytics Id')</label>
                                <input type="text" name="analytics_key" class="form-control form_control"  value="{{$general->analytics_key}}">
                               

                            </div>

                            <div class="form-group col-md-6">

                                <label for="">@changeLang('Allow Analytics')</label>

                                <select name="analytics_status" id="" class="form-control">
                                
                                    <option value="1" {{$general->analytics_status ? 'selected' : ''}}>@changeLang('Yes')</option>
                                    <option value="0" {{$general->analytics_status ? '' : 'selected'}}>@changeLang('No')</option>

                                </select>

                            </div>
                            
                            <div class="form-group col-md-8">

                               <button type="submit" class="btn btn-primary">@changeLang('Analytics Update')</button>

                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


