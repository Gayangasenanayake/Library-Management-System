<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Alluser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdduserController extends Controller
{

    public function addUser(){
        return view('add-user');
    }

    public function saveUser(Request $request){
        DB::table('allusers')->insert([
            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname,
            'guardiansname'=>$request->guardiansname,
            'guardianphone'=>$request->guardianphone,
            'address'=>$request->address,
            'gender'=>$request->gender,
            'dob'=>$request->dob,
            'grade'=>$request->grade,
            'class'=>$request->class,
            'phonenumber'=>$request->phonenumber,
            'email'=>$request->email,
            'password'=>$request->password,
            //'password'=>Hash::make($request['password']),
        ]);
        return back()->with('user_add','User add success');
    }


    public function userList(){
        $allusers =DB::table('allusers')->get();
        return view('user-list', compact('allusers'));
    }

    public function editUser($id){
        $alluser =DB::table('allusers')->where('id',$id)->first();
        return view('edit-user',compact('alluser'));
    }

    public function updateUser(Request $request){
        DB::table('allusers')->where('id',$request->id)->update([
             'firstname' =>$request->firstname,
             'lastname' =>$request->lastname,
             'guardiansname' =>$request->guardiansname,
             'guardianphone' =>$request->guardianphone,
             'address' =>$request->address,
             'gender' =>$request->gender,
             'dob' =>$request->dob,
             'grade' =>$request->grade,
             'class' =>$request->class,
             'phonenumber' =>$request->phonenumber,
             'email' =>$request->email,
             'password' =>$request->password,
        ]);
        return back()->with('user_update','User update success');
    }

    public function deleteUser($id){
        DB::table('allusers')->where('id',$id)->delete();
        return back()->with('user_delete','User delete success');
    }

    public function sendUser($id){
        $alluser =DB::table('allusers')->where('id',$id)->first();
        return view('send-user',compact('alluser'));
    }

    public function sendUserSave(Request $request){
        DB::table('users')->insert([
            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname,
            'email'=>$request->email,
            'password'=>Hash::make($request['password']),
        ]);
        return back()->with('user_save','User add success');
    }

}
