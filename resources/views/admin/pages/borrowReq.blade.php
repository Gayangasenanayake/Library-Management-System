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
    <title>Admin | Borrow Requests</title>

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
                                    <a href="/issued-Books" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage issued Books</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/borrow-req-Books" class="nav-link active">
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
                        <h1>Borrow Requests</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">Borrow Requests</li>
                        </ol>
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
                        <span class="msg">Success: {{ Session::get('fail') }}</span>
                        <div class="close-btn">
                            <span class="fas fa-times"></span>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Books Borrow Requests</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <td>User ID</td>
                                            <td>User Name</td>
                                            <td>Book ID</td>
                                            <td>Book Name</td>
                                            <td>Requested Date</td>
                                            <td>Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($books as $book)
                                            <tr>
                                                <td><a href="" data-toggle="modal" data-target="#user-details-{{$book->id}}">{{ $book->user_id }}</a></td>
                                                <td>{{ $book->user_name }}</td>
                                                <td>{{ $book->book_id}}</td>
                                                <td>{{ $book->book_name }}</td>
                                                <td>{{ $book->created_at }}</td>
                                                <td>
                                                    @if ($book->is_approved == 0)
                                                        <button class="btn btn-info btn-sm" style="float: left;" data-toggle="modal" data-target="#accept-req-{{$book->id}}">Confirm </button>
                                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#remove-req-{{$book->id}}">Cancel </button>
                                                    @elseif ($book->is_approved == 1)
                                                        <span class="badge badge-success">
                                                            <i class="fa fa-check"></i> Approved
                                                        </span>
                                                    @else
                                                        <span class="badge badge-warning">
                                                            <i class="fa fa-cancel"></i> Canceled
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>

                                            @include('admin/pages/userProfile')

                                            <div class="modal fade" id="accept-req-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;"> Confirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure to accept?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('admin.books.approve', $book->id) }}" method="post">
                                                                @csrf
                                                                <button class="btn btn-success">OK</button>
                                                            </form>
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="remove-req-{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;"> Confirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure to cancel?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('admin.books.unapprove', $book->id) }}" method="post">
                                                                @csrf
                                                                <button class="btn btn-success">OK</button>
                                                            </form>
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                        </div>
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
        "responsive": true, "lengthChange": false, "autoWidth": true,
        "buttons": ["copy", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    </script>
</body>
@endif
</html>
