<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    <link rel="shortcut icon" type="image/png" href="{{getFile('logo',$general->icon)}}">
    <link rel="stylesheet" href="{{ asset('frontend/dashboard/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/dashboard/css/font-awsome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/dashboard/css/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/dashboard/css/summernote.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/dashboard/css/bootstrap-iconpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/dashboard/css/colorpicker.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/dashboard/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/dashboard/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/dashboard/css/custom.css') }}">


    @stack('custom-style')
</head>

<body>

    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            @include('frontend.partials.top_bar')
            <div class="main-sidebar">
                @include('frontend.partials.side_bar')
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    @yield('breadcrumb')
                </section>
                @yield('content')
            </div>
            <footer class="main-footer">

            </footer>
        </div>
    </div>



    <script src="{{ asset('frontend/dashboard/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/dashboard/js/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/dashboard/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('frontend/dashboard/js/nicescroll.min.js') }}"></script>
    <script src="{{ asset('frontend/dashboard/js/summernote.js') }}"></script>
    <script src="{{ asset('frontend/dashboard/js/moment-a.js') }}"></script>
    <script src="{{ asset('frontend/dashboard/js/stisla.js') }}"></script>
    <script src="{{ asset('frontend/dashboard/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/dashboard/js/colorpicker.js') }}"></script>
    <script src="{{ asset('frontend/dashboard/js/jquery.uploadpreview.min.js') }}"></script>

    <script src="{{ asset('frontend/dashboard/js/selectric.js') }}"></script>
    <script src="{{ asset('frontend/dashboard/js/scripts.js') }}"></script>
    @include('frontend.partials.toaster')


    <script>
        'use strict'

        $('.timepicker').timepicker({
            
        });

       
    </script>
   



    @stack('custom-script')
</body>

</html>
