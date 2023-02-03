<?php

namespace App\Http\Controllers;

use App\Models\Alluser;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\category;
use App\Models\contact;
use App\Models\staff_borrow;
use App\Models\studentBorrows;
use App\Models\timeTable;
use App\Models\UserStaff;
use App\Models\UserStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class timeTableController extends Controller
{
    public function index(){
        $num = [1,3];
        $times = timeTable::all();
        $bookRequests = BookRequest::latest()->take(5)->get();
        $userReq = Alluser::latest()->take(5)->get();
        $stuextend = studentBorrows::where('status', 2)->get();
        $teextend = staff_borrow::where('status', 2)->get();
        $bookCount = count(Book::all());
        $borrowCount = count(staff_borrow::whereIn('status', $num)->get()) + count(studentBorrows::whereIn('status', $num)->get());
        $userCount = count(UserStudent::all()) + count(UserStaff::all());
        $catCount = count(category::all());
        $contacts = contact::all();

        
        return view('admin/dashboard', compact('times', 'bookRequests','userReq','stuextend','teextend','bookCount','borrowCount','userCount','catCount','contacts'));
    }

    public function updateTimetable(Request $request)
    {
        $request -> validate([
            'id'=>'required',
            'starttime'=>'required',
            'endtime'=>'required',
            'monday'=>'required',
            'tuesday'=>'required',
            'wednesday'=>'required',
            'thursday'=>'required',
            'friday'=>'required',
        ]);

        $time = timeTable::find($request->id);
        $time->time = $request->starttime." - ".$request->endtime;
        $time->Monday = $request->monday;
        $time->Tuesday = $request->tuesday;
        $time->Wednesday = $request->wednesday;
        $time->Thursday = $request->thursday;
        $time->Friday = $request->friday;
        $res = $time->save();
        if ($res) {
            return back()->with('success', 'Time table updated!');
        }else{
            return back()->with('fail', 'Something wrong!');
        }
    }
}
