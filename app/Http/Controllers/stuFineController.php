<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\studentFine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class stuFineController extends Controller
{
    function fetchBookFines()
    {
        
        // take user id from authentication session and replace with where clause '00001' value - Edited by umayanga
        // $book_fines = studentFine::join('student_borrows', 'student_fines.Book_Id', '=', 'student_borrows.Book_Id')->join('books', 'books.book_id', '=', 'student_fines.Book_Id')->where('student_fines.User_Id', '=', Auth::user()->memberid)
        // ->get(['student_borrows.Book_Id','books.book_name', 'student_fines.desc','student_fines.Total_Fine']);
       // $book_fines = DB::select("SELECT sb.Book_Id,bk.Book_Name FROM student_fines sf,student_borrows sb,books bk WHERE sf.User_Id= sb.User_Id and sb.Book_Id=bk.book_id and sf.User_Id='00001'");
       $book_fines = studentFine::where('User_Id', Auth::user()->memberid)->get();

       return view('student/pages/StufineDetails', compact('book_fines'));
    }
}
