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
    <title>Admin Panel | Add New Book | UvaLMS</title>

    {{-- include styles --}}
    @include('admin.plugins.style')
    <style>

        .qr-code-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40%;

            @media screen and (max-width: 50em) {
            width: 100%;
            margin: 8rem 0;
            }
        }
        .qr-code {
            display: flex;
            border-radius: 1rem;
            background-color: white;
            width: fit-content;
            flex-direction: column;
            justify-content: space-between;
            padding: 2rem;
        }

        .qr-code button {
            display: flex;
            justify-content: center;
            background-color: #1f1f1f;
            color: #eae6e5;
            border: none;
            outline: none;
            width: 100%;
            margin-top: 2.5rem;
            border-radius: 1rem;      
        }
        .qr-code a {
            font-family: "Poppins", sans-serif;
            font-size: 1.5rem;
            width: 100%;
            height: 100%;
            text-decoration: none;
            color: #eae6e5;
            padding: 1rem;
        }
        .qr-code i {
            margin-left: 0.5rem;
        }

        /* alert box */
   
       .closebtn {
       margin-left: 15px;
       color: white;
       font-weight: bold;
       float: right;
       font-size: 30px;
       line-height: 20px;
       cursor: pointer;
       transition: 0.3s;
       }
   
       .closebtn:hover {
       color: black;
       }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
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
                                <a href="/addBook" class="nav-link active">
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
                            <a href="" class="nav-link">
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

        @if (!isset($books))
            {{-- page top content --}}
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Add New Book</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                                    <li class="breadcrumb-item active">Add New Book</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>

                <div class="content qr">
                    @if(Session::has('success'))
                        <div class="alert alert-success" id="alert">
                            <p>
                                Book added! Book ID: {{ Session::get('success') }}
                                <input type="hidden" name="bookid" class="form-control bookId" id="bookId" value="{{ Session::get('success') }}">
                                <button class="btn ml-3 generateQr" style="background-color: gold"><i class="fa-solid fa-qrcode"></i> Generate QR Code</button>
                                <span class="closebtn" onclick="document.getElementById('alert').style.display='none';">&times;</span> 
                            </p>
                        </div>
                    @endif
                    @if(Session::has('fail'))
                        <div class="alert alert-danger" id="alert">
                            <p>
                                {{ Session::get('fail') }}
                                <span class="closebtn" onclick="document.getElementById('alert').style.display='none';">&times;</span> 
                            </p>
                        </div>
                    @endif
                    <div class="container-fluid">
                        <div class="row "> <!--qr-->
                            <div class="col-md-6">

                                <!--form-->
                                <div class="card card-success">
                                    <div class="card-header">
                                    <h3 class="card-title">Add Book</h3>
                                    </div>
                                    <form method="POST" action="{{ route('book.add_newbook') }}" class="form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                
                                            <div class="form-group">
                                                <label for="bookName">Book Name</label>
                                                <input type="text" value="{{old('bookName')}}" name="bookName" class="form-control" id="bookName" placeholder="Enter book Name" required>
                                                <span class="text-danger">@error('bookName') {{$message}} @enderror</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="bookName">Price (Rs.)</label>
                                                <input type="text" name="price" value="{{old('price')}}" class="form-control" placeholder="Enter price" required>
                                                <span class="text-danger">@error('price') {{$message}} @enderror</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="authorId">Book Description</label>
                                                <textarea name="book-desc" id="book-desc" value="{{old('book-desc')}}" cols="30" rows="5" class="form-control" placeholder="Enter Book Description" required></textarea>
                                                <span class="text-danger">@error('book-desc') {{$message}} @enderror</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="authorId">Quantity</label>
                                                <input type="text" name="quantity" value="{{old('quantity')}}" class="form-control" id="quantity" placeholder="Enter quantity" required>
                                                <span class="text-danger">@error('quantity') {{$message}} @enderror</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="authorId">Author Name</label>
                                                <input type="text" name="authorName" value="{{old('authorName')}}" class="form-control" id="authorId" placeholder="Enter author Name" required>
                                                <span class="text-danger">@error('authorName') {{$message}} @enderror</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="authorId">Category</label>
                                                <select name="categoryId" class="form-select form-control" size="3" aria-label="size 3 select example" required>
                                                    <option value="000" disabled="disabled">Book Categories</option>
                                                    @foreach ($category as $item)
                                                        <option value="{{$item->categoryId}}">{{$item->categoryName}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">@error('categoryId') {{$message}} @enderror</span>
                                            </div>
                                            <div class="form-group">
                                                <input type="file" name="file" required>
                                            </div>
                                            <span class="text-danger">@error('file') {{$message}} @enderror</span>
                                            
                                            <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Complete</label>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a class="btn btn-success" data-toggle="modal" data-target="#add-book">Submit</a>
                                        </div>

                                        <div class="modal fade" id="add-book" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content" style="width: 600px;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="demoModalLabel" style="float: left;">Confirmation</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Have you check all details?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Confirm</button>
                                                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <!--end form-->
                            </div>

                            <div class="col-md-6">
                                <div class="jumbotron mx-auto w-75 border my-4 py-4 text-center qr-code-container" style="display: none;">
                                    <div class="qr-code"></div>
                                </div>
                            </div>

                        </div><!--row-->
                    </div><!--container-fluid-->
                </div><!--content-->
            </div><!--content-wrapper-->
        @else
            {{-- page top content --}}
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Edit Book</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                                    <li class="breadcrumb-item active">Edit Book</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                
                <div class="content">
                    @if(Session::has('success'))
                    <div class="alert" id="alert">
                        <p>
                            {{ Session::get('success') }}
                            <span class="closebtn" onclick="document.getElementById('alert').style.display='none';">&times;</span> 
                        </p>
                    </div>
                @endif
                @if(Session::has('fail'))
                    <div class="alert alert-danger" id="alert">
                        <p>
                            {{ Session::get('fail') }}
                            <span class="closebtn" onclick="document.getElementById('alert').style.display='none';">&times;</span> 
                        </p>
                    </div>
                @endif
                    <div class="container-fluid">
                        <div class="row qr">
                            <div class="col-md-6">

                                    <!--form-->
                                    <div class="card card-primary">
                                        <div class="card-header">
                                        <h3 class="card-title">Edit Book</h3>
                                        </div>
                                        <form method="POST" action="{{ route('book.update.book') }}" class="form">
                                            @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="bookId">Book ID</label>
                                                <input type="text" name="id" class="form-control bookId" id="bookId" value="{{ $books->book_id }}" placeholder="Enter book Id" required disabled >
                                                <input type="hidden" name="bookid" value="{{ $books->book_id }}">

                                            </div>
                                            <div class="form-group">
                                                <label for="bookName">Book Name</label>
                                                <input type="text" name="bookName" class="form-control" id="bookName" value="{{ $books->book_name }}" placeholder="Enter book Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="authorId">Book Description</label>
                                                <input type="textarea" name="book-desc" id="book-desc" cols="30" rows="5" class="form-control" value="{{ $books->book_desc }}" placeholder="Enter Book Description" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="authorId">Quantity</label>
                                                <input type="text" name="quantity" class="form-control" id="quantity" placeholder="Enter quantity" value="{{ $books->quantity }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="authorId">Author Name</label>
                                                <input type="text" name="authorName" class="form-control" id="authorId" value="{{ $books->author_name }}" placeholder="Enter author Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="authorId">Category</label>
                                                <select name="categoryId" class="form-select form-control" size="3" aria-label="size 3 select example" required>
                                                    <option value="000" disabled="disabled">Book Categories</option>
                                                    <option value="100">General Books | සාමාන්‍ය කෘති</option>
                                                    <option value="200">Philosophy and Psychology | දර්ශනය සහ මනෝ විද්‍යාව</option>
                                                    <option value="300">Religion | ආගම</option>
                                                    <option value="400">Language | භාෂාව</option>
                                                    <option value="500">Natural science and maths | ස්වාභාව විද්‍යාව සහ ගණිතය</option>
                                                    <option value="600">Technology | තාක්ෂණ විද්‍යා</option>
                                                    <option value="700">Art | කලා</option>
                                                    <option value="800">Literature | සාහිත්‍ය</option>
                                                    <option value="900">Geography | භූගෝල විද්‍යාව</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="authorId">Book image path: book-images/</label>
                                                <input type="text" name="bookImage" class="form-control" id="authorId" value="{{$books->book_image }}" placeholder="Enter book image path (ex: categoryFolderName/image.jpg) " required>
                                            </div>
                                            <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Complete</label>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                        </form>
                                    </div>
                                    <!--end form-->

                            </div>
                        </div><!--row-->
                    </div><!--container-fluid-->
                </div><!--content-->
            </div><!--content-wrapper-->
        @endif
        

        {{-- include footer  --}}
        @include('admin/footer')
    </div><!--wrapper-->

    {{-- include script --}}
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js"') }}"></script>
    
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    
    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    
    
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- Uva collage app -->
    <!-- jQuery Mapael -->
    <script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    
    <!-- DataTables  & Plugins -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    
    <script>

        let btn = document.querySelector(".alert .generateQr");

        btn.addEventListener("click", () => {
            let qrId = document.querySelector(".alert .bookId");
            let id = qrId.value.trim();
            btn.innerText = "Generating QR Code...";

            if(id.value != "") {
                if(document.querySelector(".qr-code").childElementCount == 0){
                    generate(id);
                    btn.innerText = `Generate QR Code`;
                } else{
                    document.querySelector(".qr-code").innerHTML = "";
                    generate(id);
                }
            } else {
                document.querySelector(".qr-code-container").style = "display: none";
                console.log("not valid input");
            }
        })

        function generate(id) {
            var qrcode = new QRCode(document.querySelector(".qr-code"), {
                text: `${id}`,
                width: 220, //default 128
                height: 220,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.L
            });
            let download = document.createElement("button");
            document.querySelector(".qr-code").appendChild(download);

            let download_link = document.createElement("a");
            download_link.setAttribute("download", `${id}.png`);
            download_link.innerText = `Download`;
            download.appendChild(download_link);

            let qr_code_img = document.querySelector(".qr-code img");
            let qr_code_canvas = document.querySelector("canvas")

            if(qr_code_img.getAttribute("src") == null){
                setTimeout(() => {
                    download_link.setAttribute("href", `${qr_code_canvas.toDataURL()}`);
                }, 300);
            } else {
                setTimeout(() => {
                    download_link.setAttribute("href", `${qr_code_img.getAttribute("src")}`);
                }, 300);
            }
            document.querySelector(".qr-code-container").style = "display: ''";
        }

    </script>

</body>
@endif
</html>