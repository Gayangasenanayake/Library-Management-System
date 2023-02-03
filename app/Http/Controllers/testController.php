<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\contact;
use Dasundev\LaravelTextit\Support\Facades\Textit;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function getData()
    {
        $id = "B0001";
        $book = Book::where('book_id', $id)->get();
        return view('admin.test', compact('book'));
    }

    public function contactus(Request $req)
    {
        $contact = new contact();
        $contact->firstname = $req->firstname;
        $contact->lastname = $req->lastname;
        $contact->email = $req->email;
        $contact->phone = $req->phone;
        $contact->message = $req->message;
        $res = $contact->save();
        
        //send
        Textit::sms($req->phone, "Hi ".$req->fname."<br> Your message was sent successfully! Our team will contact you soon."); 
        // using facade

        if ($res) {
            return response()->json(['success'=>'Your message was sent successfully! Our team will contact you soon.']);
        }else{
            return response()->json(['fail'=>'Something wrong.']);
        }
    }

    public function contactReply(Request $req)
    {
        $contact = contact::where('id', $req->id)->first();
        //send
        $mssg = Textit::sms($contact->phone, "Hi ".$contact->firstname.",<br>".$req->reply); 
        // using facade

        $contact->response = 1;
        $res = $contact->save();

        if ($res && $mssg) {
            return back()->with('success','Reply sent!');
        }else{
            return back()->with('fail','Something went wrong!');
        }
    }
}
