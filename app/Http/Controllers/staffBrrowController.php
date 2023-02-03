<?php

namespace App\Http\Controllers;

use App\Models\staff_borrow;
use App\Models\staff_borrows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class staffBrrowController extends Controller
{
    function fetchBorrowBooks()
    {
        
        // take user id from authentication session and replace with where clause '00001' value - Edited by umayanga
        $borrow_books = staff_borrow::where('User_Id',Auth::user()->memberid)->get();
        return view('staff/pages/borrowDetail', compact('borrow_books'));
    }

    public function extendsBorrowBooks()
    {
        // $extends_books = studentBorrows::where('User_Id',"=", '00001')->first();
        // return view('student/pages/StuextendReturn', compact('extends_books'));

        $extends_books = staff_borrow::where('User_Id',Auth::user()->memberid)->get();;
        return view('staff/pages/extendReturn', compact('extends_books'));
    }

    public function extendsRequest($id){
        $extend_req = staff_borrow::find($id);
        $extend_req->status=2;
        $res = $extend_req->save();
        if($res){
            return back()->with('success','Request sent!');
        }else{
            return back()->with('fail','Something wrong');
        }
    }
}