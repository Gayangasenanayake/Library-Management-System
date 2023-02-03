<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Alluser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class NotificationController extends Controller
{


    public function NotificationList(){
        $notifications =DB::table('notifications')->get();
        return view('notification', compact('notifications'));
    }

    public function Notificationread($id){
        DB::table('notifications')->where('id',$id)->update([
             'read' => 1,
        ]);
        return back();
    }

    public function Notificationdelete($id)
    {
        DB::table('notifications')->where('id',$id)->delete();
        return back();
    }

}
