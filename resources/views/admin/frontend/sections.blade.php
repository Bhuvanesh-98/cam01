@extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Manage Sections')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

<div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                   <h4>@changeLang('Sections')</h4>
                   
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <tr>
                          <th>@changeLang('Sl').</th>
                          <th>@changeLang('Section Name')</th>
                          <th>@changeLang('Action')</th>
                        </tr>

                        @forelse($sections as $key => $section)
                        <tr>

                          <td>
                            {{$loop->iteration}}
                          </td>
                          <td>
                            {{ucwords($key)}}
                          </td>
                         
                          <td>

                            <a href="{{route('admin.frontend.section.manage',['name'=>$key])}}" class="btn btn-icon btn-primary"><i class="fa fa-cog"></i></a> 

                          </td>
                        </tr>
                        @empty

                            <tr>

                                <td class="text-center text-danger" colspan="100%">@changeLang('No Data Found')</td>
                            
                            </tr>
                        @endforelse
                    
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection