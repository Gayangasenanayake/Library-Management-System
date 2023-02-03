<<<<<<< HEAD
<?php

namespace App\Http\Controllers;
use App\Models\staff_fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class staffFineController extends Controller
{
    function fetchBookFines()
    {
        
       $book_fines = staff_fine::where('User_Id', Auth::user()->memberid)->get();
       return view('staff/pages/fineDetails', compact('book_fines'));
    }
}
=======
<?php

namespace App\Http\Controllers;
use App\Models\staff_fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class staffFineController extends Controller
{
    function fetchBookFines()
    {
        
       $book_fines = staff_fine::where('User_Id', Auth::user()->memberid)->get();
       return view('staff/pages/fineDetails', compact('book_fines'));
    }
}
>>>>>>> 40566e28ea7d73aa94597f6cb825faae6f73a573
