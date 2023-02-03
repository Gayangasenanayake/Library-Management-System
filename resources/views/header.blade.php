
  <div class="col-sm-6">
    @if (Auth::check())
        <div class="topbar-links">
            <a href="#" style="float: left; margin-right: 10px;"> Hi! <b>{{ Auth::user()->firstname }}</b></a>
            <?php $count = DB::table('notifications')->where('memberid', Auth::user()->memberid)->where('read', 0)->get();?>
            <!-- Notifications Dropdown Menu -->
            <div class="dropdown" style="float: left;" data-toggle="modal" data-target="#demoModal">
                <a class="nav-link" data-toggle="dropdown" href="#">
                  @if ($count->count() != 0)
                    <span class="badge ml-2" style="background-color: brown;">{{$count->count();}}</span>
                  @endif
                    <i class="fas fa-bell"></i>
                </a>
                <!--notification dropdown list-->
                <div class="dropdown-menu dropdown-menu-lg" style="padding: 20px 20px; background-color: rgb(27, 27, 27);">
                    @foreach($count as $notification)
                        @if( Auth::user()->memberid == $notification->memberid)
                            <a href="#" class="dropdown-item">
                                <!-- notification view Start -->
                                <div class="media" style="border-bottom: 1px solid rgb(147, 147, 147)">
                                    <p class="text-sm" style="margin-top: 10px;">{{$notification->notification}}</p>
                                </div>
                                <!-- notification view End -->
                            </a>
                        @endif
                    @endforeach
                    <div class="dropdown-item">
                      <div class="dropdown-divider"></div>
                      <div class="media-body" style="margin: 10px; color: white; cursor: pointer;">
                          All notifications
                      </div>
                  </div>
                </div>
            </div>
            @if (Auth::user()->is_admin == 1)
              <a href="{{route('admin.panel')}}" class="btn btn-dark">Admin Panel</a>
            @endif   
            <a class="btn btn-danger btn-sm" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

            {{-- <main class="py-4">
                @yield('content')
            </main> --}}
        </div>
    @else
        <div class="topbar-links">
            <a href="{{route('login')}}"><i class="fa fa-lock"></i>Login /</a>
            <a href="{{route('registration')}}">Register</a>
            <span>|</span>
        </div>
    @endif
</div>
