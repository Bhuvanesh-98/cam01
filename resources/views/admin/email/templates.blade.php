@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Email Templates')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>@changeLang('Sl')</th>
                                <th>@changeLang('Name')</th>
                                <th>@changeLang('Subject')</th>
                                <th>@changeLang('Action')</th>
                            </tr>
                           
                            @forelse ($emailTemplates as $key => $email)

                                <tr>
                                
                                    <td>{{ $key + $emailTemplates->firstItem() }}</td>
                                    <td>{{str_replace('_',' ', $email->name)}}</td>
                                    <td>{{$email->subject}}</td>
                                    <td>

                                        <a href="{{route('admin.email.templates.edit', $email)}}" class="btn btn-primary"><i class="fa fa-pen"></i></a>
                                    
                                    
                                    </td>
                                
                                
                                
                                </tr>
                            @empty

                                <tr>

                                    <td class="text-center" colspan="100%">@changeLang('No Email Template Found')</td>
                                
                                </tr>
                                
                            @endforelse
                        </table>
                    </div>
                </div>
                @if($emailTemplates->hasPages())

                    <div class="card-footer">

                        {{$emailTemplates->links('admin.partials.paginate')}}
                    
                    </div>


                @endif
            </div>
        </div>
    </div>


@endsection
