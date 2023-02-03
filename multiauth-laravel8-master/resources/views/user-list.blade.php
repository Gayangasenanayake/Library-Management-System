<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            padding: 5px;
            border: 1px solid;
        }
    </style>
</head>

<body>


    <div class="container">
        <a href="/add-user" class="link-light" style="text-decoration: none;">
        <div class="d-grid gap-2">
            <br>
            <button type="button" button class="btn btn-primary btn-lg pb-4 pt-4" >ADD USER</button>
            <br>
        </div>
        </a>
        @if(Session::has('user_delete'))
        <span>{{Session::get('user_delete')}}</span>
        @endif
        <table class="table table-striped table-hover">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Guardians Name</th>
                <th>Guardian Phone</th>
                <th>Address</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>Grade</th>
                <th>Class</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Password</th>

                <th>Action</th>
            </tr>
            @foreach($allusers as $alluser)
            <tr>
                <td>{{$alluser->id}}</td>
                <td>{{$alluser->firstname}}</td>
                <td>{{$alluser->lastname}}</td>
                <td>{{$alluser->guardiansname}}</td>
                <td>{{$alluser->guardianphone}}</td>
                <td>{{$alluser->address}}</td>
                <td>{{$alluser->gender}}</td>
                <td>{{$alluser->dob}}</td>
                <td>{{$alluser->grade}}</td>
                <td>{{$alluser->class}}</td>
                <td>{{$alluser->phonenumber}}</td>
                <td>{{$alluser->email}}</td>
                <td>{{$alluser->password}}</td>


                <td>
                    <a href="/edit-user/{{$alluser->id}}">
                        <button type="button" class="btn btn-primary btn-sm" style="float: left;">
                            Edit
                        </button>
                    </a>
                    <a href="/delete-user/{{$alluser->id}}">
                        <button type="button" class="btn btn-danger btn-sm" style="float: left;">
                            Delete
                        </button>
                    </a>

                    <a href="/send-user/{{$alluser->id}}">
                        <button type="button" class="btn btn-success btn-sm" style="float: left;">
                            Send
                        </button>
                    </a>

                </td>
            </tr>
            @endforeach
        </table>
    </div>

</body>

</html>