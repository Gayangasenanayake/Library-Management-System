<?php

namespace App\Http\Controllers;

use App\Models\ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class addebookController extends Controller
{
    public function addNeweBook(Request $request)
    {

        $request->validate([
            'category' => 'required',
            'grade' => 'required',
            'subject' => 'required',
            'title' => 'required',
            'pdf' => 'required|mimes:pdf',
            'image' => 'required',
        ]);

        if ($request) {

            $request->validate([
                'image' => 'mimes:jpeg,bmp,png', //validate image type
            ]);

            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('ebooks/img'), $imageName);
            $imagepath = "ebooks/img/".$imageName;

            $pdfname = time().'.'.$request->pdf->extension();
            $request->pdf->move(public_path('ebooks/pdf'), $pdfname);
            $pdfpath = "ebooks/pdf/".$pdfname;

            $uppercase = strtoupper($request->title);
            $firstLt = substr($uppercase, 0, 2);
            $statement = DB::select("SHOW TABLE STATUS LIKE 'ebooks'");
            $nextId = $statement[0]->Auto_increment;
            $ebookId = 'EB|'.$firstLt.'|'.$nextId;


            $ebook = new ebook();
            $ebook->ebook_id = $ebookId;
            $ebook->category = $request->input('category');
            $ebook->grade = $request->input('grade');
            $ebook->subject = $request->input('subject');
            $ebook->name = $request->input('title');
            $ebook->pdf = $pdfpath;
            $ebook->img = $imagepath;
            $res = $ebook->save();
            if($res){
                return back()->with('success',$ebookId);
            }else{
                return back()->with('fail','Something wrong');
            }
        }else {
            return back()->with('success','something wrong!');
        }

 
    }
}
