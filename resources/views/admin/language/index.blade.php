@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
            @if(request()->routeIs('admin.language.navbar'))
            <h1>@changeLang('Navbar Text')</h1>
            @elseif(request()->routeIs('admin.language.website'))
            <h1>@changeLang('Website Text')</h1>
            @else
                 <h1>@changeLang('Validation Text')</h1>

            @endif
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body ">
                    <div class="table-responsive">
                        <form action="" method="POST">
                            @csrf

                            <table class="table table-bordered">
                                @foreach ($language as $key => $nav)

                                    <tr>
                                        <td class="w-50">{{ $key }}</td>
                                        <td class="w-50">
                                            <input type="text" value="{{ $nav }}" class="form-control" name="lang[{{$key}}]">
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                            
                                
                                <button type="submit" class="btn btn-primary">@changeLang('Update')</button>
                            
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
