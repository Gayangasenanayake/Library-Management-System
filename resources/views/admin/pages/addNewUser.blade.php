<!DOCTYPE html>
<html lang="en">
    @if (!Auth::check())
        @include('errors/noLogin') 
    @elseif (Auth::user()->is_admin != 1)
        @include('errors/noLogin')
    @else
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel | Add User | UvaLMS</title>

    {{-- include styles --}}
    @include('admin.plugins.style')

</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        {{-- include header  --}}
        @include('admin/header')
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-success elevation-4" style=" background-image: linear-gradient(rgb(36, 36, 36), rgb(4, 0, 224));">
            <!-- School Logo -->
            <a href="/" class="brand-link">
                <img src="{{asset('dist/img/schoolLogo.png')}}" alt="School Logo" height="50px">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel-->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{asset('icons/user.png')}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block mr-3" style="float: left;" data-toggle="modal" data-target="#admin-profile">{{ Auth::user()->firstname }}</a>
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
                </div>

                <!-- Sidebar Menu -->
                <nav>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="/admin" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <!--user-->
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Users
                                    <i class="right fa-solid fa-angles-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/userDetails" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>User Details</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/addUser" class="nav-link active">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add new user</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/user-requests" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Registration Requests</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!--Books-->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Books
                                    <i class="right fa-solid fa-angles-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/addBook" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Books</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/listed-Books" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Books</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/damaged-Books" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Damage Books</p>
                                </a>
                            </li>
                            </ul>
                        </li>

                        <!--Issue books-->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-book-bookmark"></i>
                                <p>
                                    Issue books
                                    <i class="right fa-solid fa-angles-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/issueNewBook" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Issue new Book</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/issued-Books" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage issued Books</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/borrow-req-Books" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage borrow requests</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('list.fine')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Fines Details</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!--Categories-->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Categories
                                    <i class="right fa-solid fa-angles-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('admin.addNewCategory')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.view.category')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage categories</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Ebooks -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book-bookmark"></i>
                                <p>
                                    EBooks
                                    <i class="right fa-solid fa-angles-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/inserteBook" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add EBook</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/listedEbooks" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ebooks details</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>                    
                </nav>
            </div><!--end Sidebar -->
        </aside><!-- End of Main Sidebar Container -->

        {{-- page top content --}}
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add new user</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                                <li class="breadcrumb-item active">Add new user</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <hr>
            </div>

            <div class="content">
                @if(Session::has('success'))
                    <div class="alert success hide">
                        <span class="fas fa-check-circle"></span>
                        <span class="msg">Success: {{ Session::get('success') }}</span>
                        <div class="close-btn">
                        <span class="fas fa-times"></span>
                        </div>
                    </div>
                @endif
                @if(Session::has('fail'))
                    <div class="alert danger hide">
                        <span class="fas fa-exclamation-circle"></span>
                        <span class="msg">Fail: {{ Session::get('fail') }}</span>
                        <div class="close-btn">
                            <span class="fas fa-times"></span>
                        </div>
                    </div>
                @endif
                <div class="container-fluid">
                    <div class="row ml-5">
                        <div class="col-md-2">
                            <button onclick="document.getElementById('staff-reg').style.display='none'; document.getElementById('student-reg').style.display='';" class="btn btn-info">Student Registration</button>
                        </div><!--col-->
                        <div class="col-md-3">
                            <button onclick="document.getElementById('staff-reg').style.display=''; document.getElementById('student-reg').style.display='none';" class="btn btn-primary">Staff Registration</button>
                        </div><!--col-->
                    </div><!--row-->
                    <div class="row ml-5 mt-3">
                        <div class="col-md-8" id="student-reg">
                            <div class="card">
                                <div class="card-header" style="background-color: gold;">
                                    <h3 class="text-uppercase">Student registration form</h3>
                                </div>
                
                                <div class="card-body">
                                    <form action="{{route('admin-register-user')}}" method="POST">
                                        
                                        @csrf
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example8">Index Number</label>
                                            <input type="text" class="form-control" placeholder="" name="index" value="{{old('index')}}">
                                            <span class="text-danger">@error('index') {{$message}} @enderror</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                            <label class="form-label" for="form3Example1n">First Name</label>
                                            <input type="text" class="form-control" placeholder="" name="firstname" value="{{old('firstname')}}">
                                            <span class="text-danger">@error('firstname') {{$message}} @enderror</span>
                                            </div>
                                            </div>
                
                                            <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                            <label class="form-label" for="form3Example1n">Last name</label>
                                                <input type="text" class="form-control" placeholder="" name="lastname" value="{{old('lastname')}}">
                                                <span class="text-danger">@error('lastname') {{$message}} @enderror</span>
                                            </div>
                                            </div>
                                        </div>
                
                
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                            <label class="form-label" for="form3Example1m1">Guardians name</label>
                                            <input type="text" class="form-control" placeholder="" name="guardiansname" value="{{old('guardiansname')}}">
                                            <span class="text-danger">@error('guardiansname') {{$message}} @enderror</span>
                                            </div>
                                            </div>
                
                
                                            <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <label class="form-label" for="form3Example1n1">Phone no.</label>
                                                <input type="text" class="form-control" placeholder="" name="guardianphone" value="{{old('guardianphone')}}">
                                                <span class="text-danger">@error('guardianphone') {{$message}} @enderror</span>
                                            </div>
                                            </div>
                                        </div>
                        
                                        <div class="form-outline mb-4">
                                        <label class="form-label" for="form3Example8">Address</label>
                                        <input type="text" class="form-control" placeholder="" name="address" value="{{old('address')}}">
                                        <span class="text-danger">@error('address') {{$message}} @enderror</span>
                                        </div>
                
                                        
                                        <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">
                        
                                            <h6 class="mb-0 me-4">Gender: </h6>
                        
                                            <div class="form-check form-check-inline mb-0 me-4">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="gender"
                                                id="femaleGender"
                                                value="Female"
                                            />
                                            <label class="form-check-label" for="femaleGender">Female</label>
                                            </div>
                        
                                            
                
                
                                            <div class="form-check form-check-inline mb-0 me-4">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="gender"
                                                id="maleGender"
                                                value="Male"
                                            />
                                            <label class="form-check-label" for="maleGender">Male</label>
                                            </div>
                        
                                            <span class="text-danger">@error('gender') {{$message}} @enderror</span>
                        
                                        </div>
                
                
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example9">DOB</label>
                                            <input type="date" class="form-control" id="date" name="dob" value="{{old('dob')}}" placeholder="YYY-MM-DD" type="text"/>
                                            <span class="text-danger">@error('dob') {{$message}} @enderror</span>
                                        </div>
                
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <label class="form-label" for="grade"> Grade</label>
                                                {{-- <input type="text" class="form-control" placeholder="" name="grade" value="{{old('grade')}}"> --}}
                                                <select name="grade" class="form-select form-control" size="2" aria-label="size 2 select example" required>
                                                    <option value="6">Grade 6</option>
                                                    <option value="6">Grade 7</option>
                                                    <option value="6">Grade 8</option>
                                                    <option value="6">Grade 9</option>
                                                    <option value="6">Grade 10</option>
                                                    <option value="6">Grade 11</option>
                                                    <option value="6">Grade 12</option>
                                                    <option value="6">Grade 13</option>
                                                </select>
                                                <span class="text-danger">@error('grade') {{$message}} @enderror</span>
                                            </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <label class="form-label" for="class">Class</label>
                                                {{-- <input type="text" class="form-control" placeholder="" name="class" value="{{old('class')}}"> --}}
                                                <select name="class" class="form-select form-control" size="2" aria-label="size 2 select example" required>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                    <option value="G">G</option>
                                                    <option value="H">H</option>
                                                </select>
                                                <span class="text-danger">@error('class') {{$message}} @enderror</span>
                                            </div>
                                            </div>
                                        </div>
                        
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example90">Phone number</label>
                                            <input type="text" class="form-control" placeholder="" name="phonenumber" value="{{old('phonenumber')}}">
                                            <span class="text-danger">@error('phonenumber') {{$message}} @enderror</span>
                                        </div>
                
                
                
                
                                        <div class="form-outline mb-4">
                                        <label class="form-label" for="form3Example90">Email</label>
                                            <input type="text" class="form-control" placeholder="" name="email" value="{{old('email')}}">
                                            <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                        </div>
                
                                        <div class="form-outline mb-4">
                                        <label class="form-label" for="form3Example90">Password</label>
                                            <input type="password" class="form-control" placeholder="" name="password" value="">
                                            <span class="text-danger">@error('password') {{$message}} @enderror</span>
                                        </div>
                                        <div class="d-flex justify-content-end pt-3">
                                            <button type="reset" class="btn btn-light btn-lg">Reset all</button>
                                            <a href="" class="btn btn-warning btn-lg ms-2" data-toggle="modal" data-target="#add-student">Submit form</a>
                                        </div>

                                        <div class="modal fade" id="add-student" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content" style="width: 600px;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="demoModalLabel" style="float: left;">Confirm submition</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you check all the details?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success btn-lg ms-2">Submit</button>
                                                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div><!--col-->
                        <div class="col-md-8" id="staff-reg" style=" display: none;">
                            <div class="card">
                                <div class="card-header" style="background-color: gold;">
                                    <h3 class="text-uppercase">Staff registration form</h3>
                                </div>
                
                                <div class="card-body">
                
                                <form action="{{route('admin-register-staffuser')}}" method="POST">
                
                                    @csrf
                
                
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form3Example8">Index Number</label>
                                        <input type="text" class="form-control" placeholder="TExxx" name="index" value="{{old('index')}}">
                                        <span class="text-danger">@error('index') {{$message}} @enderror</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                          <div class="form-outline">
                                          <label class="form-label" for="form3Example1n">First Name</label>
                                          <input type="text" class="form-control" placeholder="" name="firstname" value="{{old('firstname')}}">
                                           <span class="text-danger">@error('firstname') {{$message}} @enderror</span>
                                          </div>
                                        </div>
                
                                        <div class="col-md-6 mb-4">
                                          <div class="form-outline">
                                          <label class="form-label" for="form3Example1n">Last name</label>
                                            <input type="text" class="form-control" placeholder="" name="lastname" value="{{old('lastname')}}">
                                            <span class="text-danger">@error('lastname') {{$message}} @enderror</span>
                                          </div>
                                        </div>
                                    </div>
                
                      
                                      <div class="form-outline mb-4">
                                      <label class="form-label" for="form3Example8">Address</label>
                                      <input type="text" class="form-control" placeholder="" name="address" value="{{old('address')}}">
                                      <span class="text-danger">@error('address') {{$message}} @enderror</span>
                                      </div>
                
                                    
                                    <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">
                      
                                        <h6 class="mb-0 me-4">Gender: </h6>
                      
                                        <div class="form-check form-check-inline mb-0 me-4">
                                          <input
                                            class="form-check-input"
                                            type="radio"
                                            name="gender"
                                            id="femaleGender"
                                            value="Female"
                                          />
                                          <label class="form-check-label" for="femaleGender">Female</label>
                                        </div>
                      
                                        
                
                
                                        <div class="form-check form-check-inline mb-0 me-4">
                                          <input
                                            class="form-check-input"
                                            type="radio"
                                            name="gender"
                                            id="maleGender"
                                            value="Male"
                                          />
                                          <label class="form-check-label" for="maleGender">Male</label>
                                        </div>
                      
                                        <span class="text-danger">@error('gender') {{$message}} @enderror</span>
                      
                                      </div>
                
                
                
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form3Example9">DOB</label>
                                        <input type="date" class="form-control" placeholder="YYYY-MM-DD" name="dob" value="{{old('dob')}}">
                                        <span class="text-danger">@error('dob') {{$message}} @enderror</span>
                                      </div>
                
                                      
                      
                                      <div class="form-outline mb-4">
                                        <label class="form-label" for="form3Example90">Phone number</label>
                                        <input type="text" class="form-control" placeholder="" name="phonenumber" value="{{old('phonenumber')}}">
                                        <span class="text-danger">@error('phonenumber') {{$message}} @enderror</span>
                                      </div>
                
                
                
                
                                      <div class="form-outline mb-4">
                                      <label class="form-label" for="form3Example90">Email</label>
                                        <input type="text" class="form-control" placeholder="" name="email" value="{{old('email')}}">
                                        <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                    </div>
                
                                    <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example90">Password</label>
                                        <input type="password" class="form-control" placeholder="" name="password" value="">
                                        <span class="text-danger">@error('password') {{$message}} @enderror</span>
                                    </div>
                                    <div class="d-flex justify-content-end pt-3">
                                        <button type="reset" class="btn btn-light btn-lg">Reset all</button>
                                        <a href="" class="btn btn-warning btn-lg ms-2" data-toggle="modal" data-target="#add-staff">Submit form</a>
                                    </div>

                                    <div class="modal fade" id="add-staff" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="width: 600px;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="demoModalLabel" style="float: left;">Confirm submition</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you check all the details?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success btn-lg ms-2">Submit</button>
                                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                                </div>
                            </div>
                        </div>
                    </div><!--row-->
                </div><!--container-fluid-->
            </div><!--content-->

        </div><!--content-wrapper-->

        {{-- include footer  --}}
        @include('admin/footer')
    </div><!--wrapper-->

    {{-- include script --}}
    @include('admin.plugins.script')

</body>
@endif
</html>