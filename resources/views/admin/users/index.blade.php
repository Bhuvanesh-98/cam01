 @extends('admin.layout.master')
  @section('breadcrumb')
 <section class="section">
          <div class="section-header">
         @if(request()->routeIs('admin.user'))
            <h1>@changeLang('All Users')</h1>
         @else
             <h1>@changeLang('Disabled Users')</h1>

         @endif
          
        
          </div>
</section>
@endsection
 @section('content')

     <div class="row">

         <div class="col-md-12">

             <div class="card">

                 <div class="card-header">
                    <h4></h4>

                     <div class="card-header-form">
                         <form method="GET" action="{{ route('admin.user.search') }}">
                             <div class="input-group">
                                 <input type="text" class="form-control" name="search">
                                 <div class="input-group-btn">
                                     <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                 </div>
                             </div>
                         </form>
                     </div>


                 </div>


                 <div class="card-body p-0">
                     <div class="table-responsive">
                         <table class="table table-striped">
                             <thead>
                                 <tr>

                                     <th>@changeLang('Sl')</th>
                                     <th>@changeLang('Full Name')</th>
                                     <th>@changeLang('Username')</th>
                                     <th>@changeLang('Phone')</th>
                                     <th>@changeLang('Email')</th>
                                     <th>@changeLang('Country')</th>
                                     <th>@changeLang('Status')</th>
                                     <th>@changeLang('Action')</th>

                                 </tr>

                             </thead>

                             <tbody>

                                 @forelse($users as $key => $user)

                                     <tr>
                                        <td>{{$key + $users->firstItem()}}</td>
                                         <td>{{ __($user->fullname) }}</td>
                                         <td>{{ __($user->username) }}</td>
                                         <td>{{ __($user->mobile) }}</td>
                                         <td>{{ __($user->email) }}</td>
                                         <td>{{ __(@$user->address->country) }}</td>
                                         <td>

                                             @if ($user->status) <span
                                                 class='badge badge-success'>@changeLang('Active')</span> @else <span
                                                     class='badge badge-danger'>@changeLang('Inactive')</span> @endif

                                         </td>

                                         <td>

                                             <a href="{{ route('admin.user.details', $user) }}"
                                                 class="btn btn-primary"><i class="fa fa-pen"></i></a>


                                         </td>


                                     </tr>
                                 @empty


                                     <tr>

                                         <td class="text-center" colspan="100%">@changeLang('No users Found')</td>

                                     </tr>



                                 @endforelse



                             </tbody>
                         </table>
                     </div>
                 </div>

                @if($users->hasPages())
                 <div class="card-footer">

                    {{ $users->links('admin.partials.paginate') }}
                 
                 </div>
                @endif

             </div>



         </div>


     </div>


 @endsection
