@extends('frontend.layout.frontend')

@section('content')

@push('seo')
        <meta name='description' content="{{$sections->seo_description}}">
@endpush


 @include('frontend.sections.banner')
    @if ($sections->sections != null)
        @foreach ($sections->sections as $sections)
            @include('frontend.sections.'.$sections)
        @endforeach

    @endif

@endsection


@push('custom-css')
   <style>
   
    .modal-dialog {
    position:fixed;
    top:auto;
    right:auto;
    left:auto;
    bottom:0;
 }  
   
   </style> 
@endpush
