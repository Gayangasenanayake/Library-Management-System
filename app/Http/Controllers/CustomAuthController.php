<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Models\Alluser;
use App\Models\User;
use App\Models\UserStaff;
use App\Models\UserStudent;
use Dasundev\LaravelTextit\Support\Facades\Textit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Str as SupportStr;

class CustomAuthController extends Controller
{
    public function login(){
        return view("login");
    }
    public function registration(){
        return view("auth/register");
    }

    public function staffregistration(){
        return view("auth/staffregister");
    }


    public function registerUser(Request $request){
        $request -> validate([
            'index' => 'required',
            'firstname'=>'required',
            'lastname'=>'required',
            'guardiansname'=>'required',
            'guardianphone'=>'required',
            'address'=>'required',
            'gender'=>'required',
            'dob'=>'required|before:today',
            'grade'=>'required',
            'class'=>'required',
            'phonenumber'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|max:12' 
        ]);

        $alluser = new Alluser();
        $alluser ->indexNo =$request->index;
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
        if($res){
            return back()->with('success','Your registration request is recorded. Please meet librarian.');
        }else{
            return back()->with('fail','Something wrong');
        }
    }
       

    public function registerStaffUser(Request $request){
        $request -> validate([
            'index' => 'required',
            'firstname'=>'required',
            'lastname'=>'required',
            'address'=>'required',
            'gender'=>'required',
            'dob'=>'required|before:today',
            'phonenumber'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|max:12' 

        ]);
        $alluser = new Alluser();
        $alluser ->indexNo =$request->index;
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
        if($res){
            return back()->with('success','Your registration request is recorded. Please meet librarian.');
        }else{
            return back()->with('fail','Something wrong');
        }
    }

    public function resetPassword(Request $request)
    {
        // $this->validate($request, [
        //     'email' => 'required|email',
        // ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // return back()->with('failed', 'Failed! email is not registered.');
            return response()->json(['fail'=>'Failed! there is some issue with sms provider']);
        }

        if ($id = UserStaff::where('staff_Id',$user->memberid)->first()) {
            $num = $id->TeleNum;
        }
        if ($id = UserStudent::where('Stu_Id',$user->memberid)->first()) {
            $num = $id->TeleNum;
        }

        // $token = Str::random(60);
        $pin = random_int(1000, 9999);

        $user['token'] = $pin;
        // $user['is_verified'] = 0;
        $user->save();

        // Mail::to($request->email)->send(new ResetPassword($user->firstname, $token));
        $sms = Textit::sms($num, "UvaLMS. Your password reset pin: ".$pin."\n If any issue please contact librarian."); 
        
        // if($sms) {
        //     return view('auth.passwords.verify')->with('sent', 'Success! password reset pin has been sent to your mobile');
        // }
        // return back()->with('failed', 'Failed! there is some issue with sms provider');
        if ($sms) {
            return response()->json(['success'=>'Success! password reset pin has been sent to your mobile']);
        }else{
            return response()->json(['fail'=>'Failed! there is some issue with sms provider']);
        }
    }

    public function forgotPasswordValidate(Request $req)
    {
        $this->validate($req, [
            'pin' => 'required',
        ]);

        $user = User::where('token', $req->pin)->first();
        if ($user) {
            $email = $user->email;
            return view('auth.passwords.change-password', compact('email'));
        }
        return redirect()->route('password.request')->with('failed', 'Password reset pin is expired');
    }

    public function updatePassword(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user2 = UserStudent::where('Email', $request->email)->first()) {
            # code...
        }else{
            $user2 = UserStaff::where('Email', $request->email)->first();
        }
        if ($user) {
            // $user['is_verified'] = 0;
            $user['token'] = 0;
            $user['password'] = Hash::make($request->password);
            $user->save();
            $user2->Password = $request->password;
            $user2->save();
            return redirect()->route('login')->with('success', 'Success! password has been changed');
        }
        return redirect()->route('password.request')->with('failed', 'Failed! something went wrong');
    }

}
