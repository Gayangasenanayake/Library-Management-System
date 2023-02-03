<?php

namespace App\Http\Controllers;
use App\Models\student_fine;
use App\Models\staff_fine;
use App\Models\book;
use App\Models\BookRequest;
use App\Models\staff_borrow;
use App\Models\studentBorrows;
use App\Models\studentFine;
use App\Models\UserStaff;
use App\Models\UserStudent;
use Dasundev\LaravelTextit\Support\Facades\Textit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;


class FineViewController extends Controller
{
    public function getfine()
    {
        $student_fines = studentFine::all();
        $staff_fines = staff_fine::all();
        return view('admin.pages.userFinesDetails', compact('student_fines', 'staff_fines'));
    }

    public function addfine(Request $req)
    {
        if ($req->type == 'student') {

            $status = studentBorrows::find($req->id);

            $fine = new studentFine();
            $fine->User_Id = $status->User_Id;
            $fine->Book_Id = $status->Book_Id;
            $fine->desc = $req->desc;
            $fine->Total_Fine = $req->price;
            $res = $fine->save();

            $status->status = 4;
            $status->save();

            DB::table('notifications')->insert([
                'memberid' => $status->User_Id,
                'notification' =>"You paid Rs.$req->price for $status->Book_Id book.",
                'job' => "pay fine",
            ]);

            $user = UserStudent::where('Stu_Id',$status->User_Id)->first();
            
            //send
            Textit::sms($user->TeleNum, "You paid Rs.".$req->price." for ".$status->Book_Id." book."); 
            // using facade

            if ($res) {
                return back()->with('success', 'Fine paid successfull!');
            }else{
                return back()->with('fail', 'Something wrong!');
            }
        }else{
            $status = staff_borrow::find($req->id);

            $fine = new staff_fine();
            $fine->User_Id = $status->User_Id;
            $fine->Book_Id = $status->Book_Id;
            $fine->desc = $req->desc;
            $fine->Total_Fine = $req->price;
            $res = $fine->save();

            $status->status = 4;
            $status->save();

            DB::table('notifications')->insert([
                'memberid' => $status->User_Id,
                'notification' =>"You paid Rs.$req->price for $status->Book_Id book.",
                'job' => "pay fine",
            ]);

            $user = UserStaff::where('staff_Id',$status->User_Id)->first();

            //send
            Textit::sms($user->TeleNum, "You paid Rs.".$req->price." for ".$status->Book_Id." book."); 
            // using facade

            if ($res) {
                return back()->with('success', 'Fine paid successfull!');
            }else{
                return back()->with('fail', 'Something wrong!');
            }
        }
    }

    public function removeFine($id, $type)
    {
        if ($type == 'student') {
            $fine = studentFine::find($id);
            $res = $fine->delete();
            if ($res) {
                return back()->with('success', 'Fine details removed!');
            }else{
                return back()->with('fail', 'Something wrong!');
            }
        }else{
            $fine = staff_fine::find($id);
            $res = $fine->delete();
            if ($res) {
                return back()->with('success', 'Fine details removed!');
            }else{
                return back()->with('fail', 'Something wrong!');
            }
        }
    }

    // public function getbook(Request $req)
    //  {
    //     $data2=student_fine::find($req->Book_Id)->find($req->User_Id);
    //     $data2->status='1';
    //     $data2->save();
    //     return Redirect::back();
    // }

    // public function getstaffbook(Request $req)
    //  {
    //     $data2=staff_fine::find($req->Book_Id)->find($req->Staff_Id);
    //     $data2->status='1';
    //     $data2->save();
    //     return Redirect::back();
    // }
}
