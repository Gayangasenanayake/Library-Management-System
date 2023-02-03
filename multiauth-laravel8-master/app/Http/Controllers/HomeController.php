<?php

namespace App\Http\Controllers;
use App\Models\timeTable;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function adminIndex()
    {
         return view('admin.adminhome');
        // $times = timeTable::all();
        // return view('admin/dashboard', compact('times'));
    }
}
