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
