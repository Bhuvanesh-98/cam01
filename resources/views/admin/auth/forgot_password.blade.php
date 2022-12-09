@extends('admin.auth.master')

@section('content')

     
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
            <img src="{{getFile('logo', $general->logo)}}" alt="logo" class="rounded mb-5 mt-2 w-50">
            <h4 class="text-dark font-weight-normal">@changeLang('Forgot Password')?</span></h4>
            <form method="POST" action="{{route('admin.forgot.password')}}" class="needs-validation" >
            @csrf
              <div class="form-group">
                <label for="email">@changeLang('Email')</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
               
              </div>


              <div class="form-group text-right">
                <a href="{{route('admin.login')}}" class="float-left mt-3">
                  @changeLang('Back To Login')?
                </a>
                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                  @changeLang('Send Verification Code')
                </button>
              </div>

            </form>
          </div>
        </div>
   

@endsection