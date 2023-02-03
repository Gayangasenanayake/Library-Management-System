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
  <title>Admin | User Details</title>

  <!--favicon icons-->
  <link rel="shortcut icon" href="favicon/icon.png" type="image/x-icon" />

  {{-- include styles --}}
  @include('admin.plugins.style')


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
                                    <a href="/userDetails" class="nav-link active">
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h1 style="float: left;">Registered User Details:</h1>
                        <button onclick="document.getElementById('staff-details').style.display='none'; document.getElementById('student-details').style.display='';" class="btn btn-info ml-2" style="float: left;">Student Details</button>
                        <button onclick="document.getElementById('student-details').style.display='none'; document.getElementById('staff-details').style.display='';" class="btn btn-primary ml-2">Staff Details</button>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">User Details</li>
                        </ol>
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
                        <div class="card" id="student-details">
                            <div class="card-header">
                                <h3 class="card-title">Registered Student Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>User Id</th>
                                            <th>User Name</th>
                                            <th>Grade</th>
                                            <th>Gender</th>
                                            <th>DOB</th>
                                            <th>Address</th>
                                            <th>T.P. Number</th>
                                            <th>Email</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td style="cursor: pointer;" onmouseover="this.style.color='red';" onmouseout="this.style.color='';" data-toggle="modal" data-target="#user-details-{{$item->id}}">{{$item->Stu_Id}}</td>
                                                <td>{{$item->First_Name}} {{$item->Last_Name}}</td>
                                                <td>{{$item->Grade}}-{{$item->Class}}</td>
                                                <td>{{$item->Gender}}</td>
                                                <td>{{$item->DOB}}</td>
                                                <td>{{$item->Address}}</td>
                                                <td>{{$item->TeleNum}}</td>
                                                <td>{{$item->Email}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning">Option</button>
                                                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu">
                                                        {{-- <a class="dropdown-item" href="{{route('user.update',$item->id)}}">Edit</a> --}}
                                                        <a href="" class="dropdown-item" data-toggle="modal" data-target="#demoModal-student-{{$item->id}}">Edit</a>
                                                        <a class="dropdown-item" href="" data-toggle="modal" data-target="#student-remove-{{$item->id}}">Remove</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @include('admin/pages/updateUser')
                                            @include('admin/pages/userProfile')

                                            <div class="modal fade" id="student-remove-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;">Remove Confirm</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are You sure to remove {{ $item->Stu_Id }} User?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{route('student.remove',$item->id)}}" class="btn btn-success">OK</a>
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

                        <div class="card" id="staff-details" style="display: none;">
                            <div class="card-header">
                                <h3 class="card-title">Registered Staff Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>User Id</th>
                                            <th>User Name</th>
                                            <th>Gender</th>
                                            <th>DOB</th>
                                            <th>Address</th>
                                            <th>T.P. Number</th>
                                            <th>Email</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teachers as $item)
                                            <tr>
                                                <td style="cursor: pointer;" onmouseover="this.style.color='red';" onmouseout="this.style.color='';" data-toggle="modal" data-target="#user-details-{{$item->id}}" >{{$item->staff_Id}}</td>
                                                <td>{{$item->First_Name}} {{$item->Last_Name}}</td>
                                                <td>{{$item->Gender}}</td>
                                                <td>{{$item->DOB}}</td>
                                                <td>{{$item->Address}}</td>
                                                <td>{{$item->TeleNum}}</td>
                                                <td>{{$item->Email}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning">Option</button>
                                                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu">
                                                        {{-- <a class="dropdown-item" href="{{route('user.update',$item->id)}}">Edit</a> --}}
                                                        <a href="" class="dropdown-item" data-toggle="modal" data-target="#demoModal-staff-{{$item->id}}">Edit</a>
                                                        <a class="dropdown-item" href="" class="dropdown-item" data-toggle="modal" data-target="#staff-remove-{{$item->id}}">Remove</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @include('admin/pages/updateUser')
                                            @include('admin/pages/userProfile')

                                            <div class="modal fade" id="staff-remove-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="width: 600px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel" style="float: left;">Remove Confirm</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are You sure to remove {{ $item->staff_Id }} User?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{route('staff.remove',$item->id)}}" class="btn btn-success">OK</a>
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
    
    <!-- Uva App -->
    <script src="dist/js/adminlte.js"></script>

    <!-- Table control script -->
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

    <script src="{{asset('js/alert.js')}}"></script>

</body>
@endif
</html>
