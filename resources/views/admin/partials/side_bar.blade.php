 <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{route('admin.dashboard')}}">{{__(@$general->sitename)}}</a>
          </div>
          <ul class="sidebar-menu">
              <li class="nav-item dropdown {{activeMenu('admin.dashboard')}}">
                <a href="{{route('admin.dashboard')}}" class="nav-link"><i class="fas fa-home"></i><span> @changeLang('Dashboard') </span></a>
              </li>
              
              <li class="nav-item {{activeMenu('admin.category.index')}}">
                <a href="{{route('admin.category.index')}}" class="nav-link"><i class="fas fa-list"></i><span>@changeLang('Category')</span></a>
              </li>
             
              
              <li class="nav-item dropdown {{activeMenu('admin.provider*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user"></i> <span>@changeLang('Manage Provider')</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('admin.provider')}}">@changeLang('All Providers')</a></li>
                  <li><a class="nav-link" href="{{route('admin.provider.featured')}}">@changeLang('Featured Providers')</a></li>
                 
                </ul>
              </li>  
              
              
              <li class="nav-item dropdown {{activeMenu('admin.user*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user"></i> <span>@changeLang('Manage user')</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('admin.user')}}">@changeLang('All users')</a></li>
                  <li><a class="nav-link" href="{{route('admin.user.disabled')}}">@changeLang('Disabled users')</a></li>
                 
                </ul>
              </li>  
              
              

                <li class="nav-item {{activeMenu('admin.service*')}}">
                <a href="{{route('admin.service')}}" class="nav-link"><i class="fas fa-toilet-paper"></i><span>@changeLang('Manage Services')</span></a>
              </li>
              
              
              <!-- <li class="nav-item {{activeMenu('admin.blog.comment')}}">
                <a href="{{route('admin.blog.comment')}}" class="nav-link"><i class="fas fa-comments"></i><span>@changeLang('Manage Blog Comment')</span></a>
              </li> -->
              
              <li class="nav-item dropdown {{activeMenu('admin.bookings*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fab fa-hire-a-helper"></i> <span>@changeLang('Manage Bookings')</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('admin.bookings')}}">@changeLang('All bookings')</a></li>
                  <li><a class="nav-link" href="{{route('admin.bookings.completed')}}">@changeLang('Completed Bookings')</a></li>
                  <li><a class="nav-link" href="{{route('admin.bookings.incomplete')}}">@changeLang('Incomplete Bookings')</a></li>
                  <li><a class="nav-link" href="{{route('admin.bookings.end.job')}}">@changeLang('End Job Contracts')</a></li>
                 
                </ul>
              </li> 
              
              <!-- <li class="nav-item dropdown {{activeMenu('admin.frontend*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>@changeLang('Frontend')</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('admin.frontend.pages')}}">@changeLang('Pages')</a></li>
                  <li><a class="nav-link" href="{{route('admin.frontend.blog')}}">@changeLang('Blog Category')</a></li>
                  <li><a class="nav-link" href="{{route('admin.frontend.faq')}}">@changeLang('Faq Category')</a></li>
                  <li><a class="nav-link" href="{{route('admin.frontend.section')}}">@changeLang('Manage Section')</a></li>
                </ul>
              </li>
              
              <li class="nav-item dropdown {{activeMenu('admin.general*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i> <span>@changeLang('Settings')</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('admin.general.setting')}}">@changeLang('General Setting')</a></li>
                  <li><a class="nav-link" href="{{route('admin.general.preloader')}}">@changeLang('Preloader Setting')</a></li>
                  <li><a class="nav-link" href="{{route('admin.general.analytics')}}">@changeLang('Google Analytics')</a></li>
                  <li><a class="nav-link" href="{{route('admin.general.cookie')}}">@changeLang('Cookie Consent')</a></li>
                  <li><a class="nav-link" href="{{route('admin.general.rechaptcha')}}">@changeLang('Google Rechaptcha')</a></li>
                  <li><a class="nav-link" href="{{route('admin.general.live.chat')}}">@changeLang('Live Chat Setting')</a></li>
                  <li><a class="nav-link" href="{{route('admin.general.seo')}}">@changeLang('Global SEO Manager')</a></li>
                 
                </ul>
              </li>
              
              <li class="nav-item dropdown {{activeMenu('admin.payment*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-credit-card"></i> <span>@changeLang('Payment Gateway')</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('admin.payment.paypal')}}">@changeLang('Paypal')</a></li>
                  <li><a class="nav-link" href="{{route('admin.payment.stripe')}}">@changeLang('Stripe')</a></li>
                  <li><a class="nav-link" href="{{route('admin.payment.bank')}}">@changeLang('Bank Payment')</a></li>
                </ul>
              </li> -->
              
              <li class="nav-item dropdown {{activeMenu('admin.manual*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-credit-card"></i> <span>@changeLang('Manual Payments')</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('admin.manual')}}">@changeLang('Manual Payments')</a></li>
                
                </ul>
              </li>
              
              <li class="nav-item dropdown {{activeMenu('admin.withdraw*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-credit-card"></i> <span>@changeLang('Manage Withdraw')</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('admin.withdraw')}}">@changeLang('Withdraw Method')</a></li>
                  <li><a class="nav-link" href="{{route('admin.withdraw.pending')}}">@changeLang('Pending Withdraws')</a></li>
                  <!--<li><a class="nav-link" href="{{route('admin.withdraw.accepted')}}">@changeLang('Accepted Withdraws')</a></li>-->
                  <li><a class="nav-link" href="{{route('admin.withdraw.rejected')}}">@changeLang('Rejected Withdraws')</a></li>
                  
                </ul>
              </li>
              
              
              <!-- <li class="nav-item dropdown {{activeMenu('admin.email*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-envelope"></i> <span>@changeLang('Email Manager')</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('admin.email.config')}}">@changeLang('Email Configure')</a></li>
                  <li><a class="nav-link" href="{{route('admin.email.templates')}}">@changeLang('Email Templates')</a></li>
                </ul>
              </li>
              
              
              <li class="nav-item dropdown {{activeMenu('admin.language*')}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-envelope"></i> <span>@changeLang('Manage Language')</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('admin.language.navbar')}}">@changeLang('Navbar')</a></li>
                  <li><a class="nav-link" href="{{route('admin.language.website')}}">@changeLang('Website Text')</a></li>
                  <li><a class="nav-link" href="{{route('admin.language.validation')}}">@changeLang('Notification Text')</a></li>
                 
                </ul>
              </li> -->
              
              
              <li class="nav-item dropdown {{activeMenu('admin.transaction')}}">
                <a href="{{route('admin.transaction')}}" class="nav-link"><i class="fas fa-credit-card"></i><span>@changeLang('Transactions')</span></a>
              </li> 
              
              <!-- <li class="nav-item dropdown {{activeMenu('admin.subscription')}}">
                <a href="{{route('admin.subscription')}}" class="nav-link"><i class="fas fa-rss"></i><span>@changeLang('Subscribers')</span></a>
              </li>

               <li class="nav-item dropdown">
                  <a data-href="{{ route('admin.db.clear') }}" class="nav-link clear"><i class="fas fa-eraser"></i><span>@changeLang('Clear Database')</span></a>
              </li> --> 
          </ul>
        </aside>