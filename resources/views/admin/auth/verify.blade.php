@extends('admin.auth.master')

@section('content')


        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
            <img src="{{getFile('logo', $general->logo)}}" alt="logo" class="rounded mb-5 mt-2 w-50">
            <h4 class="text-dark font-weight-normal">@changeLang('Verify Code')</span></h4>
            <form method="POST" action="{{route('admin.auth.verify')}}" class="needs-validation" >
            @csrf
              <div class="form-group">
                <label for="email">@changeLang('Verification Code send To your Email')</label>
                <input type="text" class="form-control" name="code" tabindex="1" required autofocus>
                
              </div>


              <div class="form-group text-right">
                <a href="{{route('admin.login')}}" class="float-left mt-3">
                  @changeLang('Back to login')?
                </a>
                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                  @changeLang('Verify Code')
                </button>
              </div>

            </form>
          </div>
        </div>

@endsection