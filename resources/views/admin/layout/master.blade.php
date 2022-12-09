<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$pageTitle}}</title>
    <link rel="shortcut icon" href="{{getFile('logo',$general->icon)}}">
    <link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/font-awsome.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/selectric.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/summernote.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/bootstrap-iconpicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/colorpicker.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/components.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/custom.css')}}">

    @stack('custom-style')
</head>
<body>
  
<div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
         @include('admin.partials.top_bar')
      <div class="main-sidebar">
         @include('admin.partials.side_bar')
      </div>

      <!-- Main Content -->
      <div class="main-content">
        @yield('breadcrumb')
        
        @yield('content')
      </div>
      
    </div>
  </div>



  
  <!-- Modal -->
  <div class="modal fade" id="cleardb" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <form action="" method="post">
      @csrf
    
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">@changeLang('Clear Database')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
          <div class="container-fluid">
              <p>@changeLang('Are You Sure To Clear Database')</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
          <button type="submit" class="btn btn-danger">@changeLang('Clear Database')</button>
        </div>
      </div>
      </form>
    </div>
  </div>




    <script src="{{asset('backend/js/jquery.min.js')}}"></script>
    <script src="{{asset('backend/js/popper.min.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/js/nicescroll.min.js')}}"></script>
    <script src="{{asset('backend/js/summernote.js')}}"></script>
    <script src="{{asset('backend/js/select2.min.js')}}"></script>
    <script src="{{asset('backend/js/sortable.js')}}"></script>
    <script src="{{asset('backend/js/moment-a.js')}}"></script>
    <script src="{{asset('backend/js/stisla.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap-iconpicker.bundle.min.js')}}"></script>
    <script src="{{asset('backend/js/colorpicker.js')}}"></script>
    <script src="{{asset('backend/js/jquery.uploadpreview.min.js')}}"></script>
    <script src="{{asset('backend/js/chart.min.js')}}"></script>
    <script src="{{asset('backend/js/scripts.js')}}"></script>
    @include('admin.partials.toaster')

    <script>
      $(function(){
        'use strict'
        $('.clear').on('click',function(e){
          e.preventDefault();
            const modal = $('#cleardb');
            modal.find('form').attr('action',$(this).data('href'))
            modal.modal('show');
        })

      })
    
    
    </script>
    @stack('custom-script')
    
</body>
</html>