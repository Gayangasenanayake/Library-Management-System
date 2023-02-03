<!DOCTYPE html>
<html lang="en">

    @if (Auth::user()->is_admin != 1)
        @include('errors/noLogin')
    @else
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel | UvaLMS</title>

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
                    <div class="user-panel mt-3 pb-3 d-flex">
                        <div class="image">
                            <img src="{{asset('icons/user.png')}}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="" class="d-block mr-3" style="float: left;" data-toggle="modal" data-target="#admin-profile">{{ Auth::user()->firstname }}</a>
                            <a class="btn btn-danger btn-sm" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="/admin" class="nav-link active">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>

                            <!--user-->
                            <li class="nav-item">
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
                                        <a href="/addUser" class="nav-link">
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
                            <div class="col-sm-4">
                                <h1 class="m-0">Admin Dashboard</h1>
                            </div>
                            <div class="col">
                                <a href="" class="nav-link" data-toggle="modal" data-target="#newAdmin">Register new admin</a>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                                    <li class="breadcrumb-item active">Admin Dashboard</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>

                {{-- Main body content --}}
                <section class="content">
                   
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

                        <!-- Small boxes (Stat box) -->
                        <div class="row">

                            <!--col-->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box" style="background-color:lawngreen;">
                                    <div class="inner">
                                        <h3>{{$bookCount}}</h3> <!---------------------------------------------------------->
                                        <p>Listed Books</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa-solid fa-book"></i>
                                    </div>
                                    <a href="/listed-Books" class="small-box-footer" style="color: black;">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div><!--small-box bg-info-->
                            </div>

                            <!--col-->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>{{$borrowCount}}</h3><!---------------------------------------------------------->
                                        <p>Books not return yet</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa-solid fa-book-open-reader"></i>
                                    </div>
                                    <a href="/issued-Books" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div><!--small-box bg-info-->
                            </div>

                            <!--col-->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{$userCount}}</h3><!---------------------------------------------------------->
                                        <p>Registered Users</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa-solid fa-user-check"></i>
                                    </div>
                                    <a href="/userDetails" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div><!--small-box bg-info-->
                            </div>

                            <!--col-->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{$catCount}}</h3><!---------------------------------------------------------->
                                        <p>Categories</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa-solid fa-book"></i>
                                    </div>
                                    <a href="{{route('admin.view.category')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div><!--small-box bg-info-->
                            </div>
                        </div> <!--1st row-->

                        <!-- 2 nd row -->
                        <div class="row">
                            {{-- @if ($bookRequests->isEmpty()) --}}
                                <!-- Left col -->
                            <section class="col-lg-6 connectedSortable">
                                {{-- contact --}}
                                <div class="card">
                                    <div class="card-header border-transparent">
                                        <i class="fa-solid fa-message ml-3"></i>
                                        <h3 class="card-title"><b>Contact Messages </b></h3>
                        
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table id="example1" class="table m-0 table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>phone</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($contacts as $contact)
                                                        @if ($contact->response == 0)
                                                            <tr onmouseover="this.style.color='#5DADE2'" style="cursor: pointer;" onmouseout="this.style.color='#17202A'" data-toggle="modal" data-target="#contact-details-{{$contact->id}}">
                                                                <td>{{ $contact->firstname }} {{$contact->lastname}}</td>
                                                                <td>{{$contact->email}}</td>
                                                                <td>{{$contact->phone}}</td>
                                                                <td>
                                                                    <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#contact-details-{{$contact->id}}">View </a>
                                                                </td>
                                                            </tr>

                                                        @include('admin/pages/models/contact_messages')

                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                    </div>
                                    <!-- /.card-footer -->
                                </div>
                                    
                                <!-- TABLE: book borrow request -->
                                <div class="card">
                                    <div class="card-header border-transparent">
                                        <i class="fa-solid fa-book ml-3"></i>
                                        <h3 class="card-title"><b>Book borrow requests </b></h3>
                        
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table id="example1" class="table m-0 table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>User ID</th>
                                                        <th>Book ID</th>
                                                        <th>Book Name</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bookRequests as $book)
                                                        @if ($book->is_approved == 0)
                                                            <tr>
                                                                <td><a href="" data-toggle="modal" data-target="#user-details-{{$book->id}}">{{ $book->user_id }}</a></td>
                                                                <td>{{$book->book_id}}</td>
                                                                <td>{{$book->book_name}}</td>
                                                                <td>
                                                                    <form action="{{ route('admin.books.approve', $book->id) }}" method="post">
                                                                        @csrf 
                                                                        <button class="btn btn-success btn-sm">Confirm </button>
                                                                    </form>
                                                                    <form action="{{ route('admin.books.unapprove', $book->id) }}" method="post">
                                                                        @csrf
                                                                        <button class="btn btn-danger btn-sm">Cancel </button>
                                                                    </form>
                                                                </td>
                                                            </tr>

                                                        @include('admin/pages/userProfile')

                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <a href="/borrow-req-Books" class="btn btn-sm float-right" style="background-color: orange;">View All Requests</a>
                                    </div>
                                    <!-- /.card-footer -->
                                </div>

                                    <!-- TABLE: Students registration requests -->
                                <div class="card">
                                    <div class="card-header border-transparent">
                                        <i class="fa-solid fa-user ml-3"></i>
                                        <h3 class="card-title"><b>Students registration requests</b></h3>
                        
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table id="example1" class="table m-0 table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Index</th>
                                                        <th>Student Name</th>
                                                        <th>Grade & class</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($userReq as $user)
                                                        @if ($user->guardiansname != NULL)
                                                            
                                                            <tr onmouseover="this.style.color='#5DADE2'" style="cursor: pointer;" onmouseout="this.style.color='#17202A'" data-toggle="modal" data-target="#view-user-{{$user->id}}">
                                                                <td>{{$user->indexNo}}</td>
                                                                <td>{{$user->firstname}} {{$user->lastname}}</td>
                                                                <td>{{$user->grade}} - {{$user->class}}</td>
                                                                <td>
                                                                    <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#view-user-{{$user->id}}">View </a>
                                                                </td>
                                                            </tr>

                                                            <div class="modal fade" id="view-user-{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content" style="width: 600px;">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left; color: black">User Details</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                                <p style="color: blue;">Request recorded on {{$user->created_at}}</p>
                                                                                <div class="form-group row">
                                                                                    <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Index No: </label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" name="student_id" value="{{$user->indexNo}}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Name: </label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" name="student_id" value="{{$user->firstname}} {{$user->lastname}}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Grade & Class: </label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" name="student_id" value="{{$user->grade}} - {{$user->class}}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Gender: </label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" name="student_id" value="{{$user->gender}}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Address: </label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" name="student_id" value="{{$user->address}}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="userid" class="col-sm-2 col-form-label" style="color: black;">DOB: </label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" name="student_id" value="{{$user->dob}}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Email: </label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" name="student_id" value="{{$user->email}}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="userid" class="col-sm-2 col-form-label" style="color: black;">T.P.: </label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" name="student_id" value="{{$user->phonenumber}}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Gurdians Name: </label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" name="student_id" value="{{$user->guardiansname}}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Gurdians T.P.: </label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" name="student_id" value="{{$user->guardianphone}}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <a href="{{route('user.approve',$user->id)}}" class="btn btn-success"><i class="fa fa-send"></i> Confirm</a>
                                                                            <a href="{{route('user.unapprove',$user->id)}}" class="btn btn-danger">Cancel</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <a href="/user-requests" class="btn btn-sm float-right" style="background-color: orange;">View All Requests</a>
                                    </div>
                                    <!-- /.card-footer -->
                                </div>

                                

                            </section><!-- Left col end-->
                                
                            {{-- @endif --}}

                            <!-- right col -->
                            <section class="col-lg-6 connectedSortable">
                                <div class="card">
                                    <div class="card-header border-transparent">
                                        <i class="fa-solid fa-user ml-3"></i>
                                        <h3 class="card-title"><b>Teachers registration requests</b></h3>
                        
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table id="example1" class="table m-0 table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Index</th>
                                                        <th>Teacher Name</th>
                                                        <th>Phone No:</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($userReq as $user)
                                                        @if ($user->guardiansname == NULL)
                                                            <tr onmouseover="this.style.color='#5DADE2'" style="cursor: pointer;" onmouseout="this.style.color='#17202A'" data-toggle="modal" data-target="#view-staff-{{$user->id}}">
                                                                <td>{{$user->indexNo}}</td>
                                                                <td>{{$user->firstname}} {{$user->lastname}}</td>
                                                                <td>{{$user->phonenumber}}</td>
                                                                <td>
                                                                    <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#view-staff-{{$user->id}}">View </a>
                                                                </td>
                                                            </tr>

                                                            <div class="modal fade" id="view-staff-{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content" style="width: 600px;">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left; color: black">User Details</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p style="color: blue;">Request recorded on {{$user->created_at}}</p>
                                                                            <div class="form-group row">
                                                                                <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Index No: </label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" class="form-control" name="student_id" value="{{$user->indexNo}}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Name: </label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" class="form-control" name="student_id" value="{{$user->firstname}} {{$user->lastname}}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Gender: </label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" class="form-control" name="student_id" value="{{$user->gender}}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Address: </label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" class="form-control" name="student_id" value="{{$user->address}}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label for="userid" class="col-sm-2 col-form-label" style="color: black;">DOB: </label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" class="form-control" name="student_id" value="{{$user->dob}}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label for="userid" class="col-sm-2 col-form-label" style="color: black;">Email: </label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" class="form-control" name="student_id" value="{{$user->email}}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label for="userid" class="col-sm-2 col-form-label" style="color: black;">T.P.: </label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" class="form-control" name="student_id" value="{{$user->phonenumber}}" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <a href="{{route('user.approve',$user->id)}}" class="btn btn-success"><i class="fa fa-send"></i> Confirm</a>
                                                                            <a href="{{route('user.unapprove',$user->id)}}" class="btn btn-danger">Cancel</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <a href="/user-requests" class="btn btn-sm float-right" style="background-color: orange;">View All Requests</a>
                                    </div>
                                    <!-- /.card-footer -->
                                </div>
                                <div class="card">
                                    <div class="card-header border-transparent">
                                        <i class="fa-solid fa-book ml-3"></i>
                                        <h3 class="card-title"><b>Students' Extend Return Date Requests</b></h3>
                        
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table id="example1" class="table m-0 table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Student ID</th>
                                                        <th>Book ID</th>
                                                        <th>Current Return Date</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($stuextend as $user)
                                                        @if ($user->guardiansname == NULL)
                                                            <tr>
                                                                <td><a href="" data-toggle="modal" data-target="#student-details-{{$user->id}}">{{$user->User_Id}}</a></td>
                                                                <td>{{$user->Book_Id}}</td>
                                                                <td>{{$user->Return_Date}}</td>
                                                                <td>
                                                                    
                                                                    <a href="{{route('admin.accept.extend',['student',$user->id])}}" class="btn btn-success btn-sm">Accept </a>
                                                                    <a href="" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancel-extend-{{$user->id}}">Cancel </a>
                                                                </td>
                                                            </tr>
                                                        @include('admin/pages/profiles/student')

                                                            <div class="modal fade" id="cancel-extend-{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content" style="width: 600px;">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;">Confirmation</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Are sure to cancel?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <a href="{{route('admin.cancel.extend',['student',$user->id])}}" type="button" class="btn btn-success">Ok</a>
                                                                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                    </div>
                                    <!-- /.card-footer -->
                                </div>

                                <div class="card">
                                    <div class="card-header border-transparent">
                                        <i class="fa-solid fa-book ml-3"></i>
                                        <h3 class="card-title"><b>Teachers' Extend Return Date Requests</b></h3>
                        
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table id="example1" class="table m-0 table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Teacher ID</th>
                                                        <th>Book ID</th>
                                                        <th>Current Return Date</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($teextend as $staff)
                                                        @if ($staff->guardiansname == NULL)
                                                            <tr>
                                                                <td><a href="" data-toggle="modal" data-target="#staff-details-{{$staff->id}}">{{$staff->User_Id}}</a></td>
                                                                <td>{{$staff->Book_Id}}</td>
                                                                <td>{{$staff->Return_Date}}</td>
                                                                <td>
                                                                    
                                                                    <a href="{{route('admin.accept.extend',['staff',$staff->id])}}" class="btn btn-success btn-sm">Accept </a>
                                                                    <a href="" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#staff-cancel-extend-{{$staff->id}}">Cancel </a>
                                                                </td>
                                                            </tr>

                                                        @include('admin/pages/profiles/staff')

                                                            <div class="modal fade" id="staff-cancel-extend-{{$staff->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content" style="width: 600px;">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;">Confirmation</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Are sure to cancel?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <a href="{{route('admin.cancel.extend',['staff',$staff->id])}}" type="button" class="btn btn-success">Ok</a>
                                                                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                    </div>
                                    <!-- /.card-footer -->
                                </div>
                            </section><!-- right col end-->

                        </div><!-- end 2 nd row -->

                        <!--3rd row-->
                        <div>
                            <!-- Calendar -->
                            <div class="card bg-gradient-success">
                                <div class="card-header border-0">
                
                                    <h3 class="card-title">
                                        <i class="far fa-calendar-alt"></i>
                                        Time Table
                                    </h3>
                                    <!-- tools-->
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <!-- /tools -->
                                </div>
                                <!-- /card-header -->
                                <div class="card-body pt-0"> 
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Time</th>
                                                <th>Monday</th>
                                                <th>Tuesday</th>
                                                <th>Wednesday</th>
                                                <th>Thursday</th>
                                                <th>Friday</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($times as $item)
                                            <tr>
                                                <td>{{ $item->time }}</td>
                                                <td>{{ $item->Monday }}</td>
                                                <td>{{ $item->Tuesday }}</td>
                                                <td>{{ $item->Wednesday }}</td>
                                                <td>{{ $item->Thursday }}</td>
                                                <td>{{ $item->Friday }}</td>
                                                <td>
                                                    <a href="" class="btn btn-sm pl-3 pr-3" style="background-color:ivory;" data-toggle="modal" data-target="#demoModal-{{$item->id}}">Edit</a>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="demoModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left; color: black">Edit time table</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('admin.update.timetable')}}" class="form" method="POST">
                                                                @csrf
                                                                <div class="form-group row">
                                                                    <label class="col-sm-2 col-form-label" style="color: black;">Start time:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                                        <input type="time" id="appt" name="starttime" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-2 col-form-label" style="color: black;">End time:</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="time" id="appt" name="endtime" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-2 col-form-label" style="color: black;">Monday</label>
                                                                    <div class="col-sm-10">
                                                                      <input type="text" class="form-control" name="monday" value="{{ $item->Monday }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-2 col-form-label" style="color: black;">Tuesday</label>
                                                                    <div class="col-sm-10">
                                                                      <input type="text" class="form-control" name="tuesday" value="{{ $item->Tuesday }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-2 col-form-label" style="color: black;">Wednesday</label>
                                                                    <div class="col-sm-10">
                                                                      <input type="text" class="form-control" name="wednesday" value="{{ $item->Wednesday }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-2 col-form-label" style="color: black;">Thursday</label>
                                                                    <div class="col-sm-10">
                                                                      <input type="text" class="form-control" name="thursday" value="{{ $item->Thursday }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-2 col-form-label" style="color: black;">Friday</label>
                                                                    <div class="col-sm-10">
                                                                      <input type="text" class="form-control" name="friday" value="{{ $item->Friday }}" required>
                                                                    </div>
                                                                </div>
                                                            
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                        </div>
                                                            </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /card-body -->
                            </div>
                            <!-- /calender card -->

                        </div><!-- / 3rd row-->
                        
                    </div><!--container-fluid-->
                </section><!--Main body content-->


            </div><!--content-wrapper-->

            {{-- include footer  --}}
            @include('admin/footer')

    </div><!--wrapper-->

    {{-- include styles --}}
    @include('admin.plugins.script')

    <script type="text/javascript">
        $('#adminform').on('submit',function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            let fname = $('#fname').val();
            let lname = $('#lname').val();
            let email = $('#email').val();
            let phone = $('#phone').val();
            let pass = $('#pass').val();
            let confrimpass = $('#confrimpass').val();

            $.ajax({
                type: 'POST',
                url: '{{route("add.new.admin")}}',
                data: {
                    "_token": "{{csrf_token()}}",
                    fname: fname,
                    lname: lname,
                    email: email,
                    phone: phone,
                    pass: pass,
                    confrimpass: confrimpass,
                },
                success: function(response) {
                    if(response.success) {
                        $('#successMsg').show();
                        $('#id-top').show();
                        document.getElementById("id_display").innerHTML = response.id;
                        document.getElementById("adminform").reset(); 
                        console.log('success','id');
                    } else {
                        console.log('fail');
                    }
                },

                error: function(response) {
                    $('#fname-error').text(response.responseJSON.errors.fname);
                    $('#lname-error').text(response.responseJSON.errors.lname);
                    $('#email-error').text(response.responseJSON.errors.email);
                    $('#phone-error').text(response.responseJSON.errors.phone);
                    $('#pass-error').text(response.responseJSON.errors.pass);
                    $('#confirm-error').text(response.responseJSON.errors.confrimpass);
                }
            });
        });
    </script>

</body>

@endif

</html>