<?php $notifications = DB::table('notifications')->get();?>

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{ asset('dist/img/logo.png') }}" alt="AdminSchoolLogo" height="90" width="90">
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark" style=" background-image: linear-gradient(rgb(36, 36, 36), rgb(4, 1, 168));">

    <!-- top navbar left side links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin" class="nav-link">Home</a>
        </li>
        
    </ul>

    <!-- top navbar right side links -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <?php $count = DB::table('notifications')->where('memberid', Auth::user()->memberid)->where('read', 0)->get();?>
            <a class="nav-link" data-toggle="dropdown" href="" onclick="document.getElementById('count').style.display='none';">
                <i class="far fa-bell"></i>
                @if ($count->count() != 0)
                    <span id="count" class="badge badge-warning navbar-badge" style="display: ;">{{$count->count()}}</span>
                @endif
            </a>
            <!--notification dropdown list-->
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="">
                
                @foreach($count as $item)
                    @if( Auth::user()->memberid == $item->memberid)
                        <p class="dropdown-item">
                            <!-- notification view Start -->
                            <div class="media" style="cursor: pointer;">
                                <div class="media-body" style="margin: 10px;">
                                    <div class="row">
                                        <h3 class="dropdown-item-title">User</h3>
                                    </div>
                                    <p class="text-sm">{{$item->notification}}</p>
                                </div>
                            </div>
                            <!-- notification view End -->
                            <div class="dropdown-divider"></div>
                        </p>
                    @endif
                @endforeach
                <div class="dropdown-item">
                    <div class="dropdown-divider"></div>
                    <div class="media-body" style="margin: 10px;" data-toggle="modal" data-target="#demoModal">
                        All notifications
                    </div>
                </div>
            </div>
        </li>
        <!-- Full screen view -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav><!--End top nav-->
@include('notification')

@if (Auth::user()->is_admin == 1)
    @include('admin/pages/adminProfile')
@endif


{{-- add new admin form --}}
<div class="modal fade" id="newAdmin" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
    <div class="alert success hide" id="successMsg" style="display: none" >
        <span class="fas fa-check-circle"></span>
        <span class="msg">New Admin Registered successful!</span>
        <div class="close-btn">
        <span class="fas fa-times"></span>
        </div>
    </div>

    {{-- add new admin  --------------------------------------------------------------------------------------------------------------}}
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 600px;">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel" style="float: left; color: black">Add new admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <h2 style="display: none;" id="id-top"> New Admin ID: 
                    <span class="badge badge-success" id="id_display">
                    </span>
                </h2>

                <form id="adminform">
                    <?php $admins = DB::table('admins')->get();?>
                    <h5>Available Admins Details</h5>
                    <div class="form-row">
                        <div class="col">
                            <label class="form-label">Admin ID</label>
                        </div>
                        <div class="col">
                            <label class="form-label">Name</label>
                        </div>
                        <div class="col">
                            <label class="form-label">Mobile</label>
                        </div>
                        <div class="col">
                            <label class="form-label">Registered At</label>
                        </div>
                    </div>
                    @foreach ($admins as $item)
                        <div class="form-row">
                            <div class="col">
                                <span>{{$item->admin_id}}</span>
                            </div>
                            <div class="col">
                                <span>{{$item->name}}</span>
                            </div>
                            <div class="col">
                                <span>{{$item->mobile}}</span>
                            </div>
                            <div class="col">
                                <span>{{$item->created_at}}</span>
                            </div>
                        </div>
                        <hr>
                    @endforeach

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-outline">
                                <label class="form-label" for="form3Example1n">First Name</label>
                                <input type="text" id="fname" class="form-control" placeholder="" name="firstname" value="{{old('firstname')}}" required>
                                <span class="text-danger" id="fname-error">@error('firstname') {{$message}} @enderror</span>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                          <label class="form-label" for="form3Example1n">Last name</label>
                            <input type="text" id="lname" class="form-control" placeholder="" name="lastname" value="{{old('lastname')}}" required>
                            <span class="text-danger" id="lname-error">@error('lastname') {{$message}} @enderror</span>
                          </div>
                        </div>
                    </div>
             
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example90">Phone number</label>
                        <input type="text" id="phone" class="form-control" placeholder="" name="phonenumber" value="{{old('phonenumber')}}" required>
                        <span class="text-danger" id="phone-error">@error('phonenumber') {{$message}} @enderror</span>
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example90">Email</label>
                        <input type="text" id="email" class="form-control" placeholder="" name="email" value="{{old('email')}}" required> 
                        <span class="text-danger" id="email-error">@error('email') {{$message}} @enderror</span>
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example90">Password</label>
                        <input type="password" id="pass" class="form-control" placeholder="" name="password" value="" required>
                        <span class="text-danger" id="pass-error">@error('password') {{$message}} @enderror</span>
                    </div> 
                    
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example90">Confirm Password</label>
                        <input type="password" id="confrimpass" class="form-control" placeholder="" name="confirm-password" value="" required>
                        <span class="text-danger" id="confirm-error">@error('confirm-password') {{$message}} @enderror</span>
                    </div>
                    

            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-dark">Reset</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
                </form>
        </div>
    </div>
</div>