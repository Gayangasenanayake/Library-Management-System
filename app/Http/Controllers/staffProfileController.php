<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\staff;
use App\Models\User;
use App\Models\UserStaff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class staffProfileController extends Controller
{
    public function __construct(){
       
    }
    // public function showData(){
        
    //     $staff_data = (DB::table('staff')->where('Staff_Id','00001')->first());
    //     return view('staff.StaffProfile',['staff_data'=>$staff_data]);
        

    // }
    public function staffDataSave(Request $request){
        
      
        //$updateData =student::find(session('user_Id'));
        $data=[
        'First_Name'=>$request->s_fname,
        'Last_Name'=>$request->s_lname,
        'Gender'=>$request->s_gender,
        'DOB'=>$request->s_dob,
        'Address'=>$request->s_address,
        'TeleNum'=>$request->s_tel,];

        $response = UserStaff::where('staff_Id', Auth::user()->memberid)->update($data);
        
        $user = User::where('memberid',Auth::user()->memberid)->first();
        $user->firstname = $request->s_fname;
        $user->lastname = $request->s_lname;
        $user->save();
        
        if($response){
            return back()->with('success','Details updated!');
        }else{
            return back()->with('fail','Something wrong');
        }
        
        
    //    dd($request->all());
    }
    public function changePassword(Request $request){
        // echo "add";
        $staff_data = (DB::table('user_staff')->where('Staff_Id', Auth::user()->memberid)->first());
        if($request->currentpwd ==  $staff_data->Password ){
            if($request->newpwd == $request->retypepwd){
                $data=['Password'=>$request->newpwd];
                $response = UserStaff::where('Staff_Id', Auth::user()->memberid)->update($data);
                
                $user = User::where('memberid',Auth::user()->memberid)->first();
                $user->password = Hash::make($request->newpwd);
                $user->save();

                if($response){
                    return back()->with('success','Password changed!');
                }else{
                    return back()->with('fail','Something wrong');
                }
            }else{
                return back()->with('fail','New password not matched with confirmation!!');
            }
        }else{
            return back()->with('fail','Your current password wrong!!');
        }
    }
}