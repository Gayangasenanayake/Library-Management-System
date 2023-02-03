<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\students;
use App\Models\UserStaff;
use App\Models\UserStudent;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{

    public function requestBook(Request $request)
    {
        if ( $student = UserStudent::where('Stu_Id', $request->input('student_id'))->first()) {
            if(!is_null($student)){
                $stid = $student->Stu_Id;
                $stname = $student->First_Name;
            }
            $book_request = new BookRequest();
            $book_request->book_id = $request->input('book_id');
            $book_request->book_name = $request->input('book_name');
            $book_request->user_id = $stid;
            $book_request->user_name = $stname;
            $book_request->user_message = $request->input('user_message');
            $book_request->save();
            
            DB::table('notifications')->insert([
                'memberid' => "AD|01",
                'notification' =>"borrow Request from $stid user.",
                'job' => "book borrow",
            ]);
            
            // session()->flash('success', 'Book Request successfully sent !!');
            return redirect()->route('user.welcome')->with('success','Book Request successfully sent !!');
        }elseif($student = UserStaff::where('staff_Id', $request->input('student_id'))->first()){
            if(!is_null($student)){
                $stid = $student->staff_Id;
                $stname = $student->First_Name;
            }
            $book_request = new BookRequest();
            $book_request->book_id = $request->input('book_id');
            $book_request->book_name = $request->input('book_name');
            $book_request->user_id = $stid;
            $book_request->user_name = $stname;
            $book_request->user_message = $request->input('user_message');
            $book_request->save();

            DB::table('notifications')->insert([
                'memberid' => "AD|01",
                'notification' =>"borrow Request from $stid user.",
                'job' => "book borrow",
            ]);
            
            // session()->flash('success', 'Book Request successfully sent !!');
            return redirect()->route('user.welcome')->with('success','Book Request successfully sent !!');
        }  else{
            return redirect()->route('user.welcome')->with('success','You are the admin or Unknown user!!');
        }
    }

    

   
}
