<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    @stack('seo')
    <!-- Title -->
    <title>{{ @$general->sitename . '-' . $pageTitle }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ getFile('logo' , @$general->icon) }}">

    
    @stack('meta')

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/datatable.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/spacing.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/dev.css') }}">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("frontend/css/color.php?color=".str_replace('#','',@$general->color)."&color2=".str_replace('#','',@$general->secondary_color)."") }}">

    @stack('custom-css')

</head>

<body>

@php
    $cookie = App\Models\CookieConsent::first();

   
@endphp

    @if(@$cookie->allow_modal)
        @include('cookieConsent::index')
    @endif

    @if (@$general->analytics_status)

        <script async src="https://www.googletagmanager.com/gtag/js?id={{ @$general->analytics_key }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag("js", new Date());

            gtag("config", "{{ @$general->analytics_key }}");
        </script>

    @endif

    @if (@$general->blog_comment)

        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous"
                src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0&appId={{ @$general->fb_app_key }}&autoLogAppEvents=1"
                nonce="8T9eA4ui"></script>

    @endif


    @if (@$general->preloader_status)
        <!--Preloader Start-->
        <div id="preloader">
            <div id="status"
                style="background-image: url({{ asset('admin/images/preloader/' . @$general->preloader_image) }})">
            </div>
        </div>
        <!--Preloader End-->
    @endif

    <div>
        @include('frontend.partials.header')

        @if (!request()->routeIs('home') && request()->routeIs('pages'))
       
            @include('frontend.sections.breadcrumb')
       @endif

       @if(!request()->routeIs('pages'))
          @yield('breadcumb')

        @endif

        @yield('content')


        @include('frontend.sections.footer')


    </div>

    <!--Js-->
    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.collapse.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/swiper-bundle.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.filterizr.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('frontend/js/viewportchecker.js') }}"></script>
    @include('frontend.partials.toaster')
    <script src="{{ asset('frontend/js/custom.js') }}"></script>


    @if (@$general->twak_allow)
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src="https://embed.tawk.to/{{ @$general->twak_key }}";
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
        <!--End of Tawk.to Script-->


    @endif

    


    <script>
        'use strict'
        $(function() {
            $(".datepicker").datepicker({
                minDate: -1
            });

          



        });
    </script>

    <script>
        //Search
        function openSearch() {
            document.getElementById("myOverlay").style.display = "block";
        }

        function closeSearch() {
            document.getElementById("myOverlay").style.display = "none";
        }

        //Mobile Menu
        function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>


    @stack('script')

</body>

</html>
