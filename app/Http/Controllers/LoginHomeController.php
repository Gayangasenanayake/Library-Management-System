<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\category;
use App\Models\ebook;
use App\Models\timeTable;

use Illuminate\Http\Request;

class LoginHomeController extends Controller
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
        $books = Book::latest()->limit(4)->get();
        $category = category::all();
        $bookcount = count(Book::all());
        $ebookcount = count(ebook::all());
        return view('uvaHome',compact('books','category','bookcount','ebookcount'));
    }


    public function adminIndex()
    {
         return view('admin.');
        // $times = timeTable::all();
        // return view('admin/dashboard', compact('times'));
    }
}
