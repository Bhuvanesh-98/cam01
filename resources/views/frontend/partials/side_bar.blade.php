 <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{route('user.dashboard')}}">{{__(@$general->sitename)}}</a>
          </div>
          <ul class="sidebar-menu">
              <li class="nav-item dropdown {{activeMenu('user.dashboard')}}">
                <a href="{{route('user.dashboard')}}" class="nav-link"><i class="fas fa-home"></i><span>{{$navbar['Dashboard']}}</span></a>
              </li> 
              

              @if(auth()->user()->user_type == 2)
               <li class="nav-item dropdown {{activeMenu('user.service*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-toilet-paper"></i> <span>{{$navbar['Service']}}</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('user.service')}}">{{$navbar['All Services']}}</a></li>
                  <li><a class="nav-link" href="{{route('user.service.create')}}">{{$navbar['Create Service']}}</a></li>
                  <li><a class="nav-link" href="{{route('user.service.schedule')}}">{{$navbar['Service Schedule']}}</a></li>
                 
                 
                </ul>
              </li>

               <li class="nav-item dropdown {{activeMenu('user.provider.booking*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-luggage-cart"></i> <span>{{$navbar['Bookings']}}</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('user.provider.booking')}}">{{$navbar['All Bookings']}}</a></li>
                </ul>
              </li>
              
              <li class="nav-item dropdown {{activeMenu('user.withdraw*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-credit-card"></i> <span>{{$navbar['Withdraw']}}</span></a>
                <ul class="dropdown-menu">
                 <li><a href="{{route('user.withdraw')}}" class="nav-link">{{$navbar['Withdraw Money']}}</a></li>
                 <li><a href="{{route('user.withdraw.all')}}" class="nav-link">{{$navbar['All Withdraw Log']}}</a></li>
                 <li><a href="{{route('user.withdraw.pending')}}" class="nav-link">{{$navbar['Pending Withdraw']}}</a></li>
                </ul>
              </li>

              
              
              @else


              <li class="nav-item dropdown {{activeMenu('user.bookings*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-luggage-cart"></i> <span>{{$navbar['Bookings']}}</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('user.bookings')}}">{{$navbar['All Bookings']}}</a></li>
                </ul>
              </li>
              @endif

               <li class="nav-item dropdown {{activeMenu('user.transaction')}}">
                <a href="{{route('user.transaction')}}" class="nav-link"><i class="fas fa-credit-card"></i><span>{{$navbar['Transaction']}}</span></a>
              </li>
             
          </ul>
        </aside>