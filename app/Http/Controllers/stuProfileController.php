<<<<<<< HEAD
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;
use App\Models\User;
use App\Models\UserStaff;
use App\Models\UserStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class stuProfileController extends Controller
{
    public function __construct(){
        
    }
    public function showData($id){
        if ($stu_data = (DB::table('user_students')->where('Stu_Id', $id)->first())) {
            return view('student.StuProfile',['st_data'=>$stu_data]);
        }else{
            $staff_data = UserStaff::where('staff_Id', $id)->first();
            return view('staff.StaffProfile',['staff_data'=>$staff_data]);
        }
        

    }
    public function stuDataSave(Request $request){
        
      
        //$updateData =student::find(session('user_Id'));
        $data=[
        'First_Name'=>$request->s_fname,
        'Last_Name'=>$request->s_lname,
        'Grade'=>$request->s_grade,
        'Class'=>$request->s_class,
        'Gender'=>$request->s_gender,
        'DOB'=>$request->s_dob,
        'Address'=>$request->s_address,
        'TeleNum'=>$request->s_tel];

        $response = UserStudent::where('Stu_Id',$request->sid)->update($data);

        $user = User::where('memberid',$request->sid)->first();
        $user->firstname = $request->s_fname;
        $user->lastname = $request->s_lname;
        $user->save();
        
        if($response){
            return back()->with('success','Details updated!');
        }else{
            return back()->with('fail','Something wrong');
        }
        
    }
    public function changePassword(Request $request){
        // echo "add";
        $stu_data = (DB::table('user_students')->where('Stu_Id', Auth::user()->memberid)->first());
        if($request->currentpwd ==  $stu_data->Password ){
            if($request->newpwd == $request->retypepwd){
                $data=['Password'=>$request->newpwd];
                $response = UserStudent::where('Stu_Id', Auth::user()->memberid)->update($data);
                
                $user = User::where('memberid',Auth::user()->memberid)->first();
                $user->password = Hash::make($request->newpwd);
                $user->save();

                if($response){
                    return back()->with('success','Password updated!');
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
=======
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;
use App\Models\User;
use App\Models\UserStaff;
use App\Models\UserStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class stuProfileController extends Controller
{
    public function __construct(){
        
    }
    public function showData($id){
        if ($stu_data = (DB::table('user_students')->where('Stu_Id', $id)->first())) {
            return view('student.StuProfile',['st_data'=>$stu_data]);
        }else{
            $staff_data = UserStaff::where('staff_Id', $id)->first();
            return view('staff.StaffProfile',['staff_data'=>$staff_data]);
        }
        

    }
    public function stuDataSave(Request $request){
        
      
        //$updateData =student::find(session('user_Id'));
        $data=[
        'First_Name'=>$request->s_fname,
        'Last_Name'=>$request->s_lname,
        'Grade'=>$request->s_grade,
        'Class'=>$request->s_class,
        'Gender'=>$request->s_gender,
        'DOB'=>$request->s_dob,
        'Address'=>$request->s_address,
        'TeleNum'=>$request->s_tel];

        $response = UserStudent::where('Stu_Id',$request->sid)->update($data);

        $user = User::where('memberid',$request->sid)->first();
        $user->firstname = $request->s_fname;
        $user->lastname = $request->s_lname;
        $user->save();
        
        if($response){
            return back()->with('success','Details updated!');
        }else{
            return back()->with('fail','Something wrong');
        }
        
    }
    public function changePassword(Request $request){
        // echo "add";
        $stu_data = (DB::table('user_students')->where('Stu_Id', Auth::user()->memberid)->first());
        if($request->currentpwd ==  $stu_data->Password ){
            if($request->newpwd == $request->retypepwd){
                $data=['Password'=>$request->newpwd];
                $response = UserStudent::where('Stu_Id', Auth::user()->memberid)->update($data);
                
                $user = User::where('memberid',Auth::user()->memberid)->first();
                $user->password = Hash::make($request->newpwd);
                $user->save();

                if($response){
                    return back()->with('success','Password updated!');
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
>>>>>>> 40566e28ea7d73aa94597f6cb825faae6f73a573
