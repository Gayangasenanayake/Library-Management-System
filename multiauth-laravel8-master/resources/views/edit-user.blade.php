<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    @if(Session::has('user_update'))
    <span>{{Session::get('user_update')}}</span>
    @endif
    <form action="{{route('user.update')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$alluser->id}}"><br><br>
    First Name: <br> <input type="text" name="firstname" value="{{$alluser->firstname}}"><br><br>
    Last Name : <br> <input type="text" name="lastname" value="{{$alluser->lastname}}"><br><br>
    Guardians Name: <br> <input type="text" name="guardiansname" value="{{$alluser->guardiansname}}"><br><br>
    Guardian Phone: <br> <input type="text" name="guardianphone" value="{{$alluser->guardianphone}}"><br><br>
    Address: <br> <input type="text" name="address" value="{{$alluser->address}}"><br><br>
    Gender: <br> <input type="text" name="gender" value="{{$alluser->gender}}"><br><br>
    DOB: <br> <input type="text" name="dob" value="{{$alluser->dob}}"><br><br>
    Grade: <br> <input type="text" name="grade" value="{{$alluser->grade}}"><br><br>
    Class: <br> <input type="text" name="class" value="{{$alluser->class}}"><br><br>
    Phone Number: <br> <input type="text" name="phonenumber" value="{{$alluser->phonenumber}}"><br><br>
    Email: <br> <input type="text" name="email" value="{{$alluser->email}}"><br><br>
    Password: <br> <input type="text" name="password" value="{{$alluser->password}}"><br><br>
    <input type="submit" value="submit">
    </form>
</body>
</html>
