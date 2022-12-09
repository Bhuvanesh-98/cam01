@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Recaptcha Settings')</h1>
      
          
        
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
                        
                            <label for="">@changeLang('Recaptcha Key')</label>

                            <input type="text" name="recaptcha_key" class="form-control"  value="{{$rechaptcha->recaptcha_key}}">
                        
                        </div> 
                        
                        <div class="form-group col-md-6">
                        
                            <label for="">@changeLang('Recaptcha Secret')</label>
                            <input type="text" name="recaptcha_secret" class="form-control"  value="{{$rechaptcha->recaptcha_secret}}">
                        
                        </div> 


                         <div class="form-group col-md-6">
                        
                            <label for="">@changeLang('Allow Recaptcha')</label>

                            <select name="allow_recaptcha" id="" class="form-control" >

                                <option value="1" {{$rechaptcha->allow_recaptcha ? 'selected' : ''}}>@changeLang('Yes')</option>
                                <option value="0" {{$rechaptcha->allow_recaptcha ? '' : 'selected'}}>@changeLang('No')</option>
                            
                            </select>
                        
                        </div> 
                        
                        <div class="form-group col-md-12">
                    

                            <button type="submit" class="btn btn-primary">@changeLang('Update Recaptcha')</button>
                        
                        </div>
                    
                    
                    </div>
                    
                    
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
