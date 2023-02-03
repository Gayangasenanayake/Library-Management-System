<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\Alluser;
use App\Models\notification;
use App\Models\staff;
use App\Models\student;
use App\Models\User;
use App\Models\UserStaff;
use App\Models\UserStudent;
use Dasundev\LaravelTextit\Support\Facades\Textit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function viewDate()
    {
        $users = UserStudent::all();
        $teachers = UserStaff::all();
        return view('admin.pages.usersDetails', compact('users','teachers'));
    }

    public function getUser()
    {
        return view('admin.pages.addNewUser');
    }

    public function userRequest()
    {
        $users = Alluser::all();
        return view('admin.pages.userRegiReq', compact('users'));
    }

    public function userApprove($id)
    {
        $user = Alluser::find($id);
        if (!is_null($user)){
            if ($user->guardiansname != NULL) {
                $student = new UserStudent();
                // $newid = "ST|$user->grade|$user->id";
                $newid = $user->indexNo;

                $student->Stu_Id = $newid;
                $student->First_Name = $user->firstname;
                $student->Last_Name = $user->lastname;
                $student->Grade = $user->grade;
                $student->Class = $user->class;
                $student->Gender = $user->gender;
                $student->DOB = $user->dob;
                $student->Address = $user->address;
                $student->TeleNum = $user->phonenumber;
                $student->guardName = $user->guardiansname;
                $student->guardNo = $user->guardianphone;
                $student->Email = $user->email;
                $student->Password = $user->password;
                $res = $student->save();

                $login = new User();
                $login->memberid = $newid;
                $login->firstname = $user->firstname;
                $login->lastname = $user->lastname;
                $login->email = $user->email;
                $login->password = Hash::make($user->password);
                $login->is_admin = 0;
                $login->save();

               
                $noti = new notification();
                $noti->memberid = $newid;
                $noti->notification = "You have registered successfull. Your ID: $newid";
                $noti->job = "user register";
                $noti->save();

                //send
                Textit::sms($student->TeleNum, "Welcome to Uva Library!. You have registered successfull. Your ID: ".$newid); 
                // using facade

                $user->delete();
                if($res){
                    return back()->with('success','Student approved! ID: '.$newid);
                }else{
                    return back()->with('fail','Something wrong');
                }
            }else{
                $teacher = new UserStaff();
                // $newid = "TE|$user->id";
                $newid = $user->indexNo;

                $teacher->staff_Id = $newid;
                $teacher->First_Name = $user->firstname;
                $teacher->Last_Name = $user->lastname;
                $teacher->Gender = $user->gender;
                $teacher->DOB = $user->dob;
                $teacher->Address = $user->address;
                $teacher->TeleNum = $user->phonenumber;
                $teacher->Email = $user->email;
                $teacher->Password = $user->password;
                $res = $teacher->save();

                $login = new User();
                $login->memberid = $newid;
                $login->firstname = $user->firstname;
                $login->lastname = $user->lastname;
                $login->email = $user->email;
                $login->password = Hash::make($user->password);
                $login->is_admin = 0;
                $login->save();

                $noti = new notification();
                $noti->memberid = $newid;
                $noti->notification = "You have registered successfull. Your ID: $newid";
                $noti->job = "user register";
                $noti->save();

                //send
                Textit::sms($teacher->TeleNum, "Welcome to Uva Library!. You have registered successfull. Your ID: ".$newid); 
                // using facade

                $user->delete();
                if($res){
                    return back()->with('success','Teacher approved! ID: '.$newid);
                }else{
                    return back()->with('fail','Something wrong');
                }
            }
        }
    }

    public function userUnapprove($id)
    {
        $user = Alluser::find($id);
        if (!is_null($user)){
            $res = $user->delete();
            if($res){
                return back()->with('success','User registration request canceled');
            }else{
                return back()->with('fail','Something wrong');
            }
        }
    }

    public function studentRemove($id)
    {
        $user = UserStudent::find($id);
        $res = $user->delete();
        $login = User::where('memberid',$user->Stu_Id)->first();
        $login->delete();
        if($res){
            return back()->with('success','Student remove successfully');
        }else{
            return back()->with('fail','Something wrong');
        }   
    }

    public function userUpdate($id)
    {
        if ($user = UserStudent::find($id)) {
            return view('admin.pages.updateUser', compact('user'));
        }else{
            $staff = UserStaff::find($id);
            return view('admin.pages.updateUser', compact('staff'));
        }
    }

    public function studentUpdated(Request $request)
    {
        if ($student = UserStudent::find($request->id)) {
            $request -> validate([
                'firstname'=>'required',
                'lastname'=>'required',
                'guardiansname'=>'required',
                'guardianphone'=>'required',
                'address'=>'required',
                // 'gender'=>'required',
                'dob'=>'required',
                'grade'=>'required',
                'class'=>'required',
                'phonenumber'=>'required',
                'password'=>'required|min:5|max:12' 
            ]);

            $student->First_Name = $request->firstname;
            $student->Last_Name = $request->lastname;
            $student->Grade = $request->grade;
            $student->Class = $request->class;
            // $student->Gender = $request->gender;
            $student->DOB = $request->dob;
            $student->Address = $request->address;
            $student->TeleNum = $request->phonenumber;
            $student->guardName = $request->guardiansname;
            $student->guardNo = $request->guardianphone;
            $student->Password = $request->password;
            $res = $student->save();

            $login = User::where('memberid',$student->Stu_Id)->first();
            $login->firstname = $request->firstname;
            $login->lastname = $request->lastname;
            $login->password = Hash::make($request->password);
            $login->is_admin = 0;
            $login->save();

            $noti = new notification();
            $noti->memberid = $student->Stu_Id;
            $noti->notification = "Your details are updated.";
            $noti->job = "user profilr";
            $noti->save();

            

            if($res){
                return back()->with('success','Student details update successfully');
            }else{
                return back()->with('fail','Something wrong');
            } 
        }else{
            $staff = UserStaff::find($request->id);
            $request -> validate([
                'firstname'=>'required',
                'lastname'=>'required',
                'address'=>'required',
                // 'gender'=>'required',
                'dob'=>'required',
                'phonenumber'=>'required',
                'password'=>'required|min:5|max:12' 
            ]);

            $staff->First_Name = $request->firstname;
            $staff->Last_Name = $request->lastname;
            // $staff->Gender = $request->gender;
            $staff->DOB = $request->dob;
            $staff->Address = $request->address;
            $staff->TeleNum = $request->phonenumber;
            $staff->Password = $request->password;
            $res = $staff->save();

            $login = User::where('memberid',$staff->staff_Id)->first();
            $login->firstname = $request->firstname;
            $login->lastname = $request->lastname;
            $login->password = Hash::make($request->password);
            $login->is_admin = 0;
            $login->save();

            $noti = new notification();
            $noti->memberid = $staff->staff_Id;
            $noti->notification = "Your details are updated.";
            $noti->job = "user profile";
            $noti->save();

            if($res){
                return back()->with('success','Staff details update successfully');
            }else{
                return back()->with('fail','Something wrong');
            } 
        }
    }

    public function adminRegisterUser(Request $request)
    {
        $request -> validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'guardiansname'=>'required',
            'guardianphone'=>'required',
            'address'=>'required',
            'gender'=>'required',
            'dob'=>'required',
            'grade'=>'required',
            'class'=>'required',
            'phonenumber'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|max:12' 

        ]);
        $alluser = new Alluser();
        $alluser ->firstname =$request->firstname;
        $alluser ->lastname =$request->lastname;
        $alluser ->guardiansname =$request->guardiansname;
        $alluser ->guardianphone =$request->guardianphone;
        $alluser ->address =$request->address;
        $alluser ->gender =$request->gender;
        $alluser ->dob =$request->dob;
        $alluser ->grade =$request->grade;
        $alluser ->class =$request->class;
        $alluser ->phonenumber =$request->phonenumber;
        $alluser ->email =$request->email;
        $alluser ->password =$request->password;
        $res = $alluser->save();

        $users = Alluser::where('email',$request->email)->get();
        foreach ($users as $user) {
            $student = new UserStudent();
            $newid = "ST|$user->grade|$user->id";
            $student->Stu_Id = $newid;
            $student->First_Name = $user->firstname;
            $student->Last_Name = $user->lastname;
            $student->Grade = $user->grade;
            $student->Class = $user->class;
            $student->Gender = $user->gender;
            $student->DOB = $user->dob;
            $student->Address = $user->address;
            $student->TeleNum = $user->phonenumber;
            $student->guardName = $user->guardiansname;
            $student->guardNo = $user->guardianphone;
            $student->Email = $user->email;
            $student->Password = $request->password;
            $res = $student->save();

            $login = new User();
            $login->memberid = $newid;
            $login->firstname = $user->firstname;
            $login->lastname = $user->lastname;
            $login->email = $user->email;
            $login->password = Hash::make($request->password);
            $login->is_admin = 0;
            $login->save();

            $noti = new notification();
            $noti->memberid = $newid;
            $noti->notification = "You have registered successfull. Your ID: $newid";
            $noti->job = "user register";
            $noti->save();

            //send
            Textit::sms($student->TeleNum, "Welcome to Uva Library!. You have registered successfull. Your ID: ".$newid); 
            // using facade

            $user->delete();
            if($res){
                return back()->with('success','Student Registered! ID: '.$newid);
            }else{
                return back()->with('fail','Something wrong');
            }
        }
    }

    public function adminRegisterStaffUser(Request $request)
    {
        $request -> validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'address'=>'required',
            'gender'=>'required',
            'dob'=>'required',
            'phonenumber'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|max:12' 

        ]);

        $alluser = new Alluser();
        $alluser ->firstname =$request->firstname;
        $alluser ->lastname =$request->lastname;
        $alluser ->guardiansname =$request->guardiansname;
        $alluser ->guardianphone =$request->guardianphone;
        $alluser ->address =$request->address;
        $alluser ->gender =$request->gender;
        $alluser ->dob =$request->dob;
        $alluser ->grade =$request->grade;
        $alluser ->class =$request->class;
        $alluser ->phonenumber =$request->phonenumber;
        $alluser ->email =$request->email;
        $alluser ->password =$request->password;
        $res = $alluser->save();

        $users = Alluser::where('email',$request->email)->get();
        foreach ($users as $user) {
            $teacher = new UserStaff();
            $newid = "TE|$user->id";
            $teacher->staff_Id = $newid;
            $teacher->First_Name = $user->firstname;
            $teacher->Last_Name = $user->lastname;
            $teacher->Gender = $user->gender;
            $teacher->DOB = $user->dob;
            $teacher->Address = $user->address;
            $teacher->TeleNum = $user->phonenumber;
            $teacher->Email = $user->email;
            $teacher->Password = $request->password;
            $res = $teacher->save();

            $login = new User();
            $login->memberid = $newid;
            $login->firstname = $user->firstname;
            $login->lastname = $user->lastname;
            $login->email = $user->email;
            $login->password = Hash::make($request->password);
            $login->is_admin = 0;
            $login->save();

            $noti = new notification();
            $noti->memberid = $newid;
            $noti->notification = "You have registered successfull. Your ID: $newid";
            $noti->job = "user register";
            $noti->save();

            //send
            Textit::sms($teacher->TeleNum, "Welcome to Uva Library!. You have registered successfull. Your ID: ".$newid); 
            // using facade

            $user->delete();
            if($res){
                return back()->with('success','Teacher registered! ID: '.$newid);
            }else{
                return back()->with('fail','Something wrong');
            }
        }
    }

    public function staffremove($id)
    {
        $user = UserStaff::find($id);
        $res = $user->delete();
        $login = User::where('memberid',$user->staff_Id)->first();
        $login->delete();
        if($res){
            return back()->with('success','Staff remove successfully');
        }else{
            return back()->with('fail','Something wrong');
        }   
    }

}
