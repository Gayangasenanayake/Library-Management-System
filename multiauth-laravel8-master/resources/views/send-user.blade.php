<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send User</title>
</head>
<body>
    @if(Session::has('user_save'))
    <span>{{Session::get('user_save')}}</span>
    @endif
    <form action="{{route('insert.user')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$alluser->id}}"><br><br>
    First Name: <br> <input type="text" name="firstname" value="{{$alluser->firstname}}"><br><br>
    Last Name : <br> <input type="text" name="lastname" value="{{$alluser->lastname}}"><br><br>
    Email: <br> <input type="text" name="email" value="{{$alluser->email}}"><br><br>
    Password: <br> <input type="text" name="password" value="{{$alluser->password}}"><br><br>
    <input type="submit" value="submit">
    </form>
</body>
</html>
