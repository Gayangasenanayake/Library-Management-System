<?php

namespace App\Http\Controllers;
use App\Models\studentBorrows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class stuBrrowController extends Controller
{
    function fetchBorrowBooks()
    {
        
        // take user id from authentication session and replace with where clause '00001' value - Edited by umayanga
        $borrow_books = studentBorrows::join('books', 'books.book_id', '=', 'student_borrows.Book_Id')->where('student_borrows.User_Id', '=', Auth::user()->memberid)->get(['books.Book_Name','student_borrows.Book_Id','student_borrows.Borrow_Date','student_borrows.Return_Date']);
        return view('student/pages/StuborrowDetail', compact('borrow_books'));
    }

    public function extendsBorrowBooks()
    {
        // $extends_books = studentBorrows::where('User_Id',"=", '00001')->first();
        // return view('student/pages/StuextendReturn', compact('extends_books'));

        $extends_books = studentBorrows::join('books', 'books.book_id', '=', 'student_borrows.Book_Id')->where('student_borrows.User_Id', '=', Auth::user()->memberid)->get(['books.Book_Name','student_borrows.Book_Id','student_borrows.Borrow_Date','student_borrows.Return_Date','student_borrows.New_Return_Date','student_borrows.status','student_borrows.id']);
        return view('student/pages/StuextendReturn', compact('extends_books'));
    }

    public function extendsRequest($id){
        $extend_req = studentBorrows::find($id);
        $extend_req->status=2;
        $res = $extend_req->save();
        if($res){
            return back()->with('success','Request sent!');
        }else{
            return back()->with('fail','Something wrong');
        }

    }
}
