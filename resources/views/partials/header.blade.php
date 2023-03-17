<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
     {{-- <img src="{{ asset('assets/images/babcock.jpg') }}" width="100px" height="50px"> --}}
     {{ strtoupper(config('app.name', 'pharmacy')) }}
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{ count(auth()->user()->unreadNotifications) }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have {{ count(auth()->user()->unreadNotifications) }} notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @forelse (auth()->user()->unreadNotifications as $notification)
                      
                  @if($loop->iteration >= 5)
                  @break
                  @endif

                  <li>
                    @if($notification->type=="App\Notifications\AppointmentNotification")
                    <a href="{{ route('notification.read',$notification->id) }}">
                      {{ $notification->data['message'] }}
                    </a>
                    @endif
                  </li>
                  @empty
                      
                  @endforelse
                  
                
                 
                </ul>
              </li>
              {{-- <li class="footer"><a href="#">View all</a></li> --}}
            </ul>
          </li>
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('assets/images/noimage.jpg') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">
                 @auth
                {{ Ucwords(Auth::user()->name) }}
                @endauth</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('assets/images/noimage.jpg') }}" class="img-circle" alt="User Image">

                <p>
                    @auth
                    {{ Ucwords(Auth::user()->name) }}
                    @endauth
                  <small>{{  Auth::user()->roles->pluck('name')[0] }}</small>
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('user.profile') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-default btn-flat">
                            Sign out
                           
                        </button>
                    </form>
                </div>
              </li>
            </ul>
          </li>
        
        </ul>
      </div>
    </nav>
  </header>
 