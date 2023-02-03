<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
@if(Session::has('user_add'))
    <span>{{Session::get('user_add')}}</span>
    @endif
    <form action="{{route('save.user')}}" method="post">
    @csrf

    
    First Name      : <br> <input type="text" name="firstname" value=""><br><br>
    Last Name       : <br> <input type="text" name="lastname" value=""><br><br>
    Guardians Name  : <br> <input type="text" name="guardiansname" value=""><br><br>
    Guardian Phone  : <br> <input type="text" name="guardianphone" value=""><br><br>
    Address         : <br> <input type="text" name="address" value=""><br><br>
    Gender          : <br> <input type="text" name="gender" value=""><br><br>
    DOB             : <br> <input type="text" name="dob" value=""><br><br>
    Grade           : <br> <input type="text" name="grade" value=""><br><br>
    Class           : <br> <input type="text" name="class" value=""><br><br>
    Phone Number    : <br> <input type="text" name="phonenumber" value=""><br><br>
    Email           : <br> <input type="text" name="email" value=""><br><br>
    Password        : <br> <input type="text" name="password" value=""><br><br>
    <input type="submit" value="submit">
    </form>
</body>
</html>