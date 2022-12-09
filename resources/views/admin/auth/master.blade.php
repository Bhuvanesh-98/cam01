<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$pageTitle}}</title>
    <link rel="shortcut icon" type="image/png" href="{{getFile('logo',$general->icon)}}">
    
    <link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/font-awsome.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/izitoast.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/components.css')}}">

    <!-- Favicon -->
</head>
<body>

     <div id="app">
     <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
         @yield('content')
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="{{getFile('login', @$general->login_page->login_image)}}">
          <div class="absolute-bottom-left index-2">
            <div class="text-light p-5 pb-2">
              <div class="mb-5 pb-3">
                <h1 class="mb-2 display-4 font-weight-bold">{{__(@$general->login_page->overlay)}}</h1>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </section>
       
    </div>
    <script src="{{asset('backend/js/jquery.min.js')}}"></script>
    <script src="{{asset('backend/js/proper.min.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/js/scripts.js')}}"></script>
    
    @include('admin.partials.toaster')
</body>
</html>