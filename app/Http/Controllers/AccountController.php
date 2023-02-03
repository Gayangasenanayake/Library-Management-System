<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    	### Sign In
	/* After submitting the sign-in form */
	public function postSignIn(Request $request) {
		$validator = $request->validate([
				'username' 	=> 'required',
				'password'	=> 'required'

		]);
		if(!$validator) {
			// Redirect to the sign in page
			return Redirect::route('/')
				->withErrors($validator)
				->withInput();   // redirect the input

		} else {

			$remember = ($request->has('remember')) ? true : false;
			$auth = Auth::attempt(array(
				'username' => $request->get('username'),
				'password' => $request->get('password')
			), $remember);
		} 

		if($auth) {
			
			return Redirect::intended('home');

		} else {
			
			return Redirect::route('/')
				->with('global', 'Wrong Email or Wrong Password.');
		}

		return Redirect::route('/')
			->with('global', 'There is a problem. Have you activated your account?');
	}

	/* Submitting the Create User form (POST) */
	public function postCreate(Request $request) {
		// dd($request->all());
		$validator = $request->validate([
				'username'		=> 'required|max:20|min:3|unique:users',
				'password'		=> 'required',
				'password_again'=> 'required|same:password'
		]);

		if(!$validator) {
			return Redirect::route('account-create')
				->withErrors($validator)
				->withInput();   // fills the field with the old inputs what were correct

		} else {
			// create an account
			$username	= $request->get('username');
			$password 	= $request->get('password');

			$userdata = User::create([
				'username' 	=> $username,
				'password' 	=> Hash::make($password)	// Changed the default column for Password
			]);

			if($userdata) {			


				return Redirect::route('/')
					->with('global', 'Your account has been created. We have sent you an email to activate your account');				
			}
		}
	}

	public function getSignIn() {
		return view('account.signin');
	}

	/* Viewing the form (GET) */
	public function getCreate() {
		return view('account.create');
	}

	### Sign Out
	public function getSignOut() {
		Auth::logout();
		return Redirect::route('/');
	}

	public function updateAdmin(Request $req)
    {
        $req -> validate([
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email',
            'number'=>'required|Integer',
            'current_pass'=>'required',
        ]);

        $admin = admin::where('admin_id', $req->admin_id)->first();

		if ($admin->password != $req->current_pass) {
			return back()->with('fail','Entered current password is wrong!');
		}

        $admin->name = $req->fname." ".$req->lname;
        $admin->email = $req->email;
        $admin->mobile = $req->number;
		if ($req->pass) {
			$req->validate([
				'pass'=>'required|min:5|max:12',
				'confirm_pass'=>'required|same:pass',
			]);
			$admin->password = $req->pass;
		}
        $res = $admin->save();

        $login = User::where('memberid', $req->admin_id)->first();
        $login->firstname = $req->fname;
        $login->lastname = $req->lname;
        $login->email = $req->email;
		if ($req->pass) {
        	$login->password = Hash::make($req->pass);
		}
        $login->save();

        DB::table('notifications')->insert([
            'memberid' => $req->admin_id,
            'notification' =>"Your profile details updated!",
            'job' => "profile update",
        ]);
        
        if($res){
            return back()->with('success','Profile updated successful!');
        }else{
            return back()->with('fail','Something wrong');
        }
    }

	public function addNewAdmin(Request $req)
	{
		$req -> validate([
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'pass'=>'required|min:5|max:12',
            'confrimpass'=>'required|same:pass',
        ]);

		$statement = DB::select("SHOW TABLE STATUS LIKE 'admins'");
        $nextId = $statement[0]->Auto_increment;

		$admin = new admin();
		$admin->admin_id = 'AD|'.$nextId;
		$admin->name = $req->fname." ".$req->lname;
        $admin->email = $req->email;
        $admin->mobile = $req->phone;
        $admin->password = $req->pass;
        $res = $admin->save();

		$user = new User();
		$user->memberid = $admin->admin_id;
		$user->firstname = $req->fname;
		$user->lastname = $req->lname;
		$user->email = $admin->email;
		$user->password = Hash::make($admin->password);
		$user->is_admin = 1;
    	$res2 = $user->save();

		if($res && $res2){
			return response()->json(['success'=>'New Admin Registered successful!','id'=>'AD|'.$nextId]);
        }else{
			return response()->json(['fail'=>'Something went wrong!']);
        }

	}
}
