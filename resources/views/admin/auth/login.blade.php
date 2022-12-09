@extends('admin.auth.master')

@section('content')
   
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
            <img src="{{getFile('logo', $general->logo)}}" alt="logo" class="rounded mb-5 mt-2 w-50">
            <h4 class="text-dark font-weight-normal">@changeLang('Welcome To') <span class="font-weight-bold">{{$general->sitename}}</span></h4>
            <form method="POST" action="{{route('admin.login')}}" class="needs-validation" >
            @csrf
              <div class="form-group">
                <label for="email">@changeLang('Email')</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1" required>
                
              </div>

              <div class="form-group">
                
                  <label for="password" class="control-label">@changeLang('Password')</label>
               
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                
              </div>

              <div class="form-group text-right">
                <a href="{{route('admin.forgot.password')}}" class="float-left mt-3">
                  @changeLang('Forgot Password')?
                </a>
                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                  @changeLang('Login')
                </button>
              </div>

            </form>
          </div>
        </div>
       
      
@endsection