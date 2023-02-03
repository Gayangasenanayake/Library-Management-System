<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alluser;

class CustomAuthController extends Controller
{
    public function login(){
        return view("login");
    }
    public function registration(){
        return view("registration");
    }

    public function staffregistration(){
        return view("staffregistration");
    }


    public function registerUser(Request $request){
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
        if($res){
            return back()->with('success','You have registered successfully');
        }else{
            return back()->with('fail','Something wrong');
        }
    }
       

    public function registerStaffUser(Request $request){
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
        if($res){
            return back()->with('success','You have registered successfully');
        }else{
            return back()->with('fail','Something wrong');
        }
    }

}
