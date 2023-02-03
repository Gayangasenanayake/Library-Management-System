<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\student_borrow;
use Carbon\Carbon;
use Dasundev\LaravelTextit\Support\Facades\Textit;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $data = student_barrow::where('status', "0")->get();
        $status = [1, 3];
        $data = DB::table('student_borrows')->whereIn('status', $status)->get();
        foreach ($data as $item){
            $user = DB::table('user_students')->where('Stu_Id', $item->User_Id)->first();
            if ($item->status == 3) {
                if ($item->reminder_msg == 0) {
                    $date=$item->New_Return_Date;
                    $dateconverted = Carbon::parse($date);
                    $now = Carbon::now()->timezone('Asia/colombo');
                    $diff = $dateconverted->lessThan($now);
                    $tp= $user->TeleNum;
                    if ($diff) {
                        Textit::sms($tp, 'Hello, '.$user->First_Name.' '.$item->Book_Name.' book is delay. Please return it on tommorrow.');
                        // $item->reminder_msg = 1;
                        // $item->save();
                        DB::table('student_borrows')->where('id', $item->id)->update(['reminder_msg' => 1]);
                    }
                }
            }else {
                if ($item->reminder_msg == 0) {
                    $date=$item->Return_Date;
                    $dateconverted = Carbon::parse($date);
                    $now = Carbon::now()->timezone('Asia/colombo');
                    $diff = $dateconverted->lessThan($now);
                    $tp= $user->TeleNum;
                    if ($diff) {
                        Textit::sms($tp, 'Hello, '.$user->First_Name.' '.$item->Book_Name.' book is delay. Please return it on tommorrow.');
                        // $item->reminder_msg = 1;
                        // $item->save();
                        DB::table('student_borrows')->where('id', $item->id)->update(['reminder_msg' => 1]);
                    }
                }
            }
        }

        $data = DB::table('staff_borrows')->whereIn('status', $status)->get();
        foreach ($data as $item){
            $user = DB::table('user_staff')->where('staff_Id', $item->User_Id)->first();
            if ($item->status == 3) {
                if ($item->reminder_msg == 0) {
                    $date=$item->New_Return_Date;
                    $dateconverted = Carbon::parse($date);
                    $now = Carbon::now()->timezone('Asia/colombo');
                    $diff = $dateconverted->lessThan($now);
                    $tp= $user->TeleNum;
                    if ($diff) {
                        Textit::sms($tp, 'Hello, '.$user->First_Name.' '.$item->Book_Name.' book is delay. Please return it on tommorrow.');
                        // $item->reminder_msg = 1;
                        // $item->save();
                        DB::table('staff_borrows')->where('id', $item->id)->update(['reminder_msg' => 1]);
                    }
                }
            }else {
                if ($item->reminder_msg == 0) {
                    $date=$item->Return_Date;
                    $dateconverted = Carbon::parse($date);
                    $now = Carbon::now()->timezone('Asia/colombo');
                    $diff = $dateconverted->lessThan($now);
                    $tp= $user->TeleNum;
                    if ($diff) {
                        Textit::sms($tp, 'Hello, '.$user->First_Name.' '.$item->Book_Name.' book is delay. Please return it on tommorrow.');
                        // $item->reminder_msg = 1;
                        // $item->save();
                        DB::table('staff_borrows')->where('id', $item->id)->update(['reminder_msg' => 1]);
                    }
                }
            }
        }
    }
}
