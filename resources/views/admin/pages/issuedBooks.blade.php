<!DOCTYPE html>
<html lang="en">
    @if (!Auth::check())
        @include('errors/noLogin') 
    @elseif (Auth::user()->is_admin != 1)
        @include('errors/noLogin')
    @else
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | issued Books</title>

  <!--favicon icons-->
  <link rel="shortcut icon" href="favicon/icon.png" type="image/x-icon" />

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{asset('css/alert.css')}}">
  

  
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        {{-- include header  --}}
        @include('admin/header')
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-success elevation-4" style=" background-image: linear-gradient(rgb(36, 36, 36), rgb(4, 0, 224));">
            <!-- School Logo -->
            <a href="/" class="brand-link">
                <img src="dist/img/schoolLogo.png" alt="School Logo" height="50px">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel-->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="icons/user.png" class="img-circle elevation-2" alt="User Image">
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
                                    <a href="#" class="nav-link">
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
                        <li class="nav-item menu-open">
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
                                    <a href="/issued-Books" class="nav-link active">
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-5">
                        <h1 style="float: left;">Issued Books</h1>
                    </div>
                    <div class="col-sm-5">

                        <form class="form-inline" method="post" action="{{route('admin.search.time.range')}}">
                            @csrf
                            <div class="form-group mb-2">
                                <input type="date" name="start" class="form-control" id="staticEmail2" placeholder="start">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <input type="date" name="end" class="form-control" id="inputPassword2" placeholder="end">
                            </div>
                            <button type="submit" class="btn btn-dark mb-2">Search time period</button>
                        </form>
                    </div>
                    <div class="col-sm-2">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">Issued Books</li>
                        </ol>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5">
                        <button onclick="document.getElementById('staff-details').style.display='none'; document.getElementById('student-details').style.display='';" class="btn btn-info ml-2" style="float: left;">Student</button>
                        <button onclick="document.getElementById('student-details').style.display='none'; document.getElementById('staff-details').style.display='';" class="btn btn-primary ml-2">Staff</button>
                    </div>

                    <div class="col-sm-5">
                        <form class="form-inline">
                            <div class="form-group mb-2">
                                <span style="margin: 0 50px">Start Date</span>
                                <span class="text-danger">@error('start') {{$message}} @enderror</span>
                            </div>
                            <div class="form-group mb-2">
                                <span style="margin: 0 50px">End Date</span>
                                <span class="text-danger">@error('end') {{$message}} @enderror</span>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-dark float-sm-right" id="qr-open" data-toggle="modal" data-target="#qr-scanner"><i class="fa-solid fa-qrcode"></i></button>
                    </div>

                    <!--qr sacnner-->
                    <div class="modal fade" style="display: none;" id="qr-scanner" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content" style="width: 600px;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="demoModalLabel" style="float: left;">Scanner</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('admin.search.issuedbook')}}" method="post">
                                        @csrf
                                        <div id="reader" width="500px"></div>

                                        <div class="form-group">
                                            <label for="bookId">Book ID</label>
                                            <input type="text" name="bookid" class="form-control" id="bookid" placeholder="Enter Book Id" readonly>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                </div>
                                    </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
            <div class="container-fluid">
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
                <div class="row">
                    <div class="col-12">
                        <div class="card" id="student-details">
                            <div class="card-header">
                                <h3 class="card-title" style="width: 55%;">Student borrowed books details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Book Id</th>
                                            <th>Student Id</th>
                                            <th>Book Name</th>
                                            <th>Borrow Date</th>
                                            <th>Return Date</th>
                                            <th>Ex. Return Date</th>
                                            <th>Status</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($books as $book)
                                            <tr>
                                                <td>{{ $book->Book_Id }}</td>
                                                <td>{{ $book->User_Id }}</td>
                                                <td>{{ $book->Book_Name }}</td>
                                                <td>{{ $book->Borrow_Date }}</td>
                                                <td>{{ $book->Return_Date }}</td>
                                                <td>{{ $book->New_Return_Date }}</td>
                                                <td>
                                                    @if ($book->status == 1)
                                                            <span class="badge badge-danger">
                                                                 <i class="fa fa-times"></i> Not returned
                                                            </span>
                                                    @elseif ($book->status == 4)
                                                        <span class="badge badge-warning">
                                                            <i class="fa fa-times"></i> Payed
                                                        </span>
                                                    @elseif ($book->status == 3)
                                                        <span class="badge badge-info">
                                                            <i class="fa fa-times"></i> Return date extended
                                                        </span>
                                                    @elseif ($book->status == 2)
                                                        <span class="badge badge-dark">
                                                            <i class="fa fa-times"></i>Have extend Request
                                                        </span>
                                                    @elseif ($book->status == 5)
                                                        <span class="badge badge-dark">
                                                            <i class="fa fa-check"></i> Late return
                                                        </span>
                                                    @else
                                                        <span class="badge badge-success">
                                                                <i class="fa fa-check"></i> Returned
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($book->status > 0 && $book->status < 4)
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning">Option</button>
                                                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu">
                                                            @if (\Carbon\Carbon::now()->gt($book->Return_Date))
                                                                <a href="" class="dropdown-item" data-toggle="modal" data-target="#st-late-{{$book->id}}">Late return</a>
                                                            @else
                                                                <a href="" class="dropdown-item" href="" data-toggle="modal" data-target="#st-return-book-{{$book->id}}">Return</a>
                                                            @endif
                                                            <a href="" class="dropdown-item" data-toggle="modal" data-target="#demoModal-{{$book->id}}">Missed</a>
                                                            @if ($book->status != 3 && $book->status != 2)
                                                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#st-extend-book-{{$book->id}}">Extend return date</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @else
                                                        <i class="fa fa-check"></i>
                                                    @endif
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="st-late-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;"> Late return</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php
                                                                $start = \Carbon\Carbon::now()->toDateTimeString();
                                                                $startdate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start);
                                                                $enddate = \Carbon\Carbon::createFromFormat('Y-m-d',$book->Return_Date);
                                                                $different = $startdate->diffInDays($enddate);
                                                            ?>
                                                            <form action="{{ route('late.return') }}" method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id" value="{{$book->id}}">
                                                                    <input type="hidden" name="type" value="student">
                                                                    <label for="bookname">Book Name:</label>
                                                                    <input type="text" class="form-control" value="{{ $book->Book_Name }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="userid">User ID:</label>
                                                                    <input type="text" class="form-control" value="{{ $book->User_Id }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="userid">Return Date:</label>
                                                                    <input type="date" class="form-control" value="{{ $book->Return_Date }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="userid">Count of Late Days:</label>
                                                                    <input type="text" class="form-control" name="daycount" value="{{ $different }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="userid">Fine:</label>
                                                                    <p style="color: brown;">For one day of late return fine: Rs.5 </p>
                                                                    <input type="number" class="form-control" name="fine" value="{{ $different*5 }}" readonly>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Submit</button>
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                        </div>
                                                            </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="st-extend-book-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;"> Confirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Extend return Return of {{ $book->Book_Id }} book by 1 week.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ route('admin.extend.date', ['student', $book->id]) }}" type="submit" class="btn btn-success">Ok</a>
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="st-return-book-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;"> Confirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Return {{ $book->Book_Id }} book?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ route('admin.books.return', ['student', $book->id])}}" type="submit" class="btn btn-success">Ok</a>
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="demoModal-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;">Confirm Fine</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('add.fine') }}" method="POST">
                                                                <?php $price = DB::table('books')->where('book_Id', $book->Book_Id)->first(); ?>
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id" value="{{$book->id}}">
                                                                    <input type="hidden" name="type" value="student">
                                                                    <label for="bookid">Book ID:</label>
                                                                    <input type="text" class="form-control" value="{{ $book->Book_Id }}" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="bookname">Book Name:</label>
                                                                    <input type="text" class="form-control" value="{{ $book->Book_Name }}" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="userid">User ID:</label>
                                                                    <input type="text" class="form-control" value="{{ $book->User_Id }}" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="desc">Description:</label>
                                                                    <?php if($price != null):?>
                                                                        <p style="color: brown;">Books' value is Rs.{{$price->price}} & You must pay double <b> Rs.{{$price->price + $price->price}} </b> Because you missed this book.!</p>
                                                                        <input type="hidden" name="price" value="{{$price->price + $price->price}}">
                                                                    <?php else:?>
                                                                        <p style="color: brown;"> Something wrong with book price!</p>
                                                                    <?php endif;?>
                                                                    <textarea class="form-control"  name="desc" cols="30" rows="3" placeholder="if user payed or not?" required></textarea>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Submit</button>
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
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div class="card" id="staff-details">
                            <div class="card-header">
                                <h3 class="card-title">Staff borrowed books details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Book Id</th>
                                            <th>Staff Id</th>
                                            <th>Book Name</th>
                                            <th>Borrow Date</th>
                                            <th>Return Date</th>
                                            <th>Ex. Return Date</th>
                                            <th>Status</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($staff_books as $book)
                                            <tr>
                                                <td>{{ $book->Book_Id }}</td>
                                                <td>{{ $book->User_Id }}</td>
                                                <td>{{ $book->Book_Name }}</td>
                                                <td>{{ $book->Borrow_Date }}</td>
                                                <td>{{ $book->Return_Date }}</td>
                                                <td>{{ $book->New_Return_Date }}</td>
                                                <td>
                                                    @if ($book->status == 1)
                                                            <span class="badge badge-danger">
                                                                 <i class="fa fa-times"></i> Not returned
                                                            </span>
                                                    @elseif ($book->status == 4)
                                                        <span class="badge badge-warning">
                                                            <i class="fa fa-times"></i> Payed
                                                        </span>
                                                    @elseif ($book->status == 3)
                                                        <span class="badge badge-info">
                                                            <i class="fa fa-times"></i> Return date extended
                                                        </span>
                                                    @elseif ($book->status == 5)
                                                        <span class="badge badge-dark">
                                                            <i class="fa fa-times"></i> Late return
                                                        </span>
                                                    @elseif ($book->status == 2)
                                                        <span class="badge badge-dark">
                                                            <i class="fa fa-times"></i>Have return Request
                                                        </span>
                                                    @else
                                                        <span class="badge badge-success">
                                                                <i class="fa fa-check"></i> Returned
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($book->status == 1 || $book->status == 3)
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-warning">Option</button>
                                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu" role="menu">
                                                                @if (\Carbon\Carbon::now()->gt($book->Return_Date))
                                                                    <a href="" class="dropdown-item" data-toggle="modal" data-target="#late-{{$book->id}}">Late return</a>
                                                                @else
                                                                    <a href="" class="dropdown-item" data-toggle="modal" data-target="#return-book-{{$book->id}}">Return</a>
                                                                @endif
                                                                <a href="" class="dropdown-item" data-toggle="modal" data-target="#demoModal-{{$book->id}}">Missed</a>
                                                                @if ($book->status != 3 && $book->status != 2)
                                                                    <a href="" class="dropdown-item" data-toggle="modal" data-target="#extend-book-{{$book->id}}">Extend return date</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <i class="fa fa-check"></i>
                                                    @endif
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="late-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;"> Late return</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php
                                                                $start = \Carbon\Carbon::now()->toDateTimeString();
                                                                $startdate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start);
                                                                $enddate = \Carbon\Carbon::createFromFormat('Y-m-d',$book->Return_Date);
                                                                $different = $startdate->diffInDays($enddate);
                                                            ?>
                                                            <form action="{{ route('late.return') }}" method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id" value="{{$book->id}}">
                                                                    <input type="hidden" name="type" value="staff">
                                                                    <label for="bookname">Book Name:</label>
                                                                    <input type="text" class="form-control" value="{{ $book->Book_Name }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="userid">User ID:</label>
                                                                    <input type="text" class="form-control" value="{{ $book->User_Id }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="userid">Return Date:</label>
                                                                    <input type="date" class="form-control" value="{{ $book->Return_Date }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="userid">Count of Late Days:</label>
                                                                    <input type="text" class="form-control" name="daycount" value="{{ $different }}" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="userid">Fine:</label>
                                                                    <p style="color: brown;">For one day of late return fine: Rs.5 </p>
                                                                    <input type="number" class="form-control" name="fine" value="{{ $different*5 }}" readonly>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Submit</button>
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                        </div>
                                                            </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="extend-book-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;"> Confirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Extend return Return of {{ $book->Book_Id }} book by 1 week.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ route('admin.extend.date', ['staff', $book->id]) }}" type="submit" class="btn btn-success">Ok</a>
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="return-book-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;"> Confirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Return {{ $book->Book_Id }} book?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ route('admin.books.return', ['staff', $book->id])}}" type="submit" class="btn btn-success">Ok</a>
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="demoModal-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;">Confirm Fine</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('add.fine') }}" method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id" value="{{$book->id}}">
                                                                    <input type="hidden" name="type" value="staff">
                                                                    <label for="bookid">Book ID:</label>
                                                                    <input type="text" class="form-control" value="{{ $book->Book_Id }}" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="bookname">Book Name:</label>
                                                                    <input type="text" class="form-control" value="{{ $book->Book_Name }}" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="userid">User ID:</label>
                                                                    <input type="text" class="form-control" value="{{ $book->User_Id }}" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="desc">Description:</label>
                                                                    <p style="color: brown;">Books' value is Rs.{{$price->price}} & You must pay double <b> Rs.{{$price->price + $price->price}} </b> Becaouse you missed this book.!</p>
                                                                    <input type="hidden" name="price" value="{{$price->price + $price->price}}">
                                                                    <textarea class="form-control"  name="desc" cols="30" rows="3" placeholder="if user payed or not?" required></textarea>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Submit</button>
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
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
       

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        {{-- include footer  --}}
        @include('admin/footer')
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <script src="{{asset('js/alert.js')}}"></script>


    <!-- Page specific script -->
    <script>
    $(function () {
        $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    $(function () {
        $("#example2").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    });
    </script>

    {{-- qr scanner  --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        let btn = document.getElementById("qr-open");
        btn.addEventListener('click', event => {
            function onScanSuccess(decodedText, decodedResult) {
            $("#bookid").val(decodedText);
            html5QrcodeScanner.clear();
            }

            function onScanFailure(error) {
                console.warn(`Code scan error = ${error}`);
            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",{ fps: 10, qrbox: 250 });

            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });
    </script>

</body>
@endif
</html>
