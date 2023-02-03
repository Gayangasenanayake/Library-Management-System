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
  <title>Admin | Listed Books</title>

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
                        <li class="nav-item menu-open">
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
                                <a href="/listed-Books" class="nav-link active">
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Listed Books</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item active">Listed Books</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-5">
                        </div>
                        <div class="col-sm-5">
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-dark float-sm-right" id="qr-open" data-toggle="modal" data-target="#qr-scanner"><i class="fa-solid fa-qrcode"></i></button>
                        </div>
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
                                    <form action="{{route('admin.search.book.details')}}" method="post">
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

                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Listed Books Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Book ID</th>
                                            <th>Book Image</th>
                                            <th>Book Name</th>
                                            <th>Price (Rs.)</th>
                                            <th>Category ID</th>
                                            <th>Author Name</th>
                                            <th>Status</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($books as $book)
                                            <tr>
                                                <td data-toggle="modal" data-target="#view-book-{{$book->id}}" style="cursor: pointer;" onmouseover="this.style.color='red';" onmouseout="this.style.color='';">{{ $book->book_id }}</td>
                                                <td><img src="{{ asset('book-images/'.$book->book_image) }}" alt="{{ $book->book_id }}" width="50px"></td>
                                                <td>{{ $book->book_name }}</td>
                                                <td>{{ $book->price }}</td>
                                                <td>{{ $book->category_id }}</td>
                                                <td>{{ $book->author_name }}</td>
                                                @if ( $book->quantity > 0)
                                                    <td style="color: green">{{ $book->quantity }} copies Available</td>
                                                @else
                                                    <td style="color: red">Not Available</td>
                                                @endif
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning">Option</button>
                                                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu">
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#edit-book-{{$book->id}}" href="">Edit</a>
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#book-remove-{{$book->id}}" href="">Remove</a>
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#book-damage-{{$book->id}}" href="">Add to damage</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            @include('admin.pages.models.bookDetail')

                                            <div class="modal fade" id="book-damage-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;">Add to damage Confirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('admin.add.damage')}}" method="POST">
                                                                @csrf
                                                                <div class="form-group row">
                                                                    <input type="hidden" name="id" value="{{$book->id}}">
                                                                    <label for="authorId">Quantity: </label>
                                                                    <div class="col-sm-3">
                                                                        <div class="input-group">
                                                                            <span class="input-group-prepend">
                                                                                <button type="button" class="btn btn-outline-secondary btn-number" disabled="disabled" data-type="minus" data-field="quantity">
                                                                                    <span class="fa fa-minus"></span>
                                                                                </button>
                                                                            </span>
                                                                            <input type="text" name="quantity" class="form-control input-number" value="1" min="1" max="1000">
                                                                            <span class="input-group-append">
                                                                                <button type="button" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="quantity">
                                                                                    <span class="fa fa-plus"></span>
                                                                                </button>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <span style="color: crimson;">Select count of damaged books.</span>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Ok</button>
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                        </div>
                                                            </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="book-remove-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;">Remove Confirm</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are You sure to remove {{ $book->book_id }} book?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{route('admin.remove.book', $book->id)}}" class="btn btn-success">OK</a>
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Edit Book Details -----------------------------------------------}}
                                            <div class="modal fade" id="edit-book-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;">Edit Book Details</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('book.update.book') }}" class="form">
                                                                @csrf
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <img src="{{ asset('book-images/'.$book->book_image) }}" alt="{{ $book->book_id }}" width="100px">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="bookId">Book ID</label>
                                                                        <input type="text" name="bookid" class="form-control bookId" id="bookId" value="{{ $book->book_id }}" placeholder="Enter book Id" readonly>                        
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="bookName">Book Name</label>
                                                                        <input type="text" name="bookName" class="form-control" id="bookName" value="{{ $book->book_name }}" placeholder="Enter book Name" required>
                                                                        <span class="text-danger">@error('bookName') {{$message}} @enderror</span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="authorId">Book Description</label>
                                                                        <input type="textarea" name="book-desc" id="book-desc" cols="30" rows="5" class="form-control" value="{{ $book->book_desc }}" placeholder="Enter Book Description" required>
                                                                        <span class="text-danger">@error('book-desc') {{$message}} @enderror</span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="bookName">Book Value (Rs.)</label>
                                                                        <input type="text" name="bookprice" class="form-control" id="bookprice" value="{{ $book->price }}" placeholder="Enter book Name" required>
                                                                        <span class="text-danger">@error('bookprice') {{$message}} @enderror</span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="authorId">Quantity</label>
                                                                        <span class="text-danger">@error('quantity') {{$message}} @enderror</span>
                                                                        <input type="text" name="quantity" class="form-control" id="quantity" placeholder="Enter quantity">
                                                                        <span style="color: crimson;">Library already have {{ $book->quantity  }} copies of this book. <b>Please only enter count of copies you want to add.</b> Otherwise keep this field empty.</span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="authorId">Author Name</label>
                                                                        <input type="text" name="authorName" class="form-control" id="authorId" value="{{ $book->author_name }}" placeholder="Enter author Name" required>
                                                                        <span class="text-danger">@error('authorName') {{$message}} @enderror</span>
                                                                    </div>
                                                                    <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                                                    <label class="form-check-label" for="exampleCheck1">Complete</label>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Update</button>
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
    
    <!-- Uva App -->
    <script src="dist/js/adminlte.js"></script>
    <script src="{{asset('js/alert.js')}}"></script>


    <!-- Table control script -->
    <script>
    $(function () {
        $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    </script>
    <script>
        $('.btn-number').click(function(e){
            e.preventDefault();
            
            fieldName = $(this).attr('data-field');
            type      = $(this).attr('data-type');
            var input = $("input[name='"+fieldName+"']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if(type == 'minus') {
                    
                    if(currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    } 
                    if(parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if(type == 'plus') {

                    if(currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if(parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });

        $('.input-number').focusin(function(){
            $(this).data('oldValue', $(this).val());
        });

        $('.input-number').change(function() {
            
            minValue =  parseInt($(this).attr('min'));
            maxValue =  parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());
            
            name = $(this).attr('name');
            if(valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if(valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }
        });

        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) || 
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
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
