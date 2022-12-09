@extends('admin.layout.master')

@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Tawk Live Chat Settings')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post">
                    
                    @csrf

                    <div class="row">
                    
                    
                        <div class="form-group col-md-6">
                        
                            <label for="">@changeLang('Allow Tawk Live Chat')</label>

                            <select name="twak_allow" id="" class="form-control" >

                                <option value="1" {{$twakto->twak_allow ? 'selected' : ''}}>@changeLang('Yes')</option>
                                <option value="0" {{$twakto->twak_allow ? '' : 'selected'}}>@changeLang('No')</option>
                            
                            </select>
                        
                        </div> 
                        
                        <div class="form-group col-md-6">
                        
                            <label for="">@changeLang('Tawk Key')</label>

                            <input type="text" name="twak_key" class="form-control"  value="{{$twakto->twak_key}}">
                        
                        </div> 
    
                        
                        <div class="form-group col-md-12">
                    

                            <button type="submit" class="btn btn-primary">@changeLang('Update Tawk Live Chat')</button>
                        
                        </div>
                    
                    
                    </div>
                    
                    
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
