<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookRequest;
use App\Models\Books;
use App\Models\category;
use App\Models\ebook;
use App\Models\notification;
use App\Models\staff_borrow;
use App\Models\staff_fine;
use App\Models\student_borrow;
use App\Models\studentBorrows;
use App\Models\studentFine;
use App\Models\UserStaff;
use App\Models\UserStudent;
use Carbon\Carbon;
use Dasundev\LaravelTextit\Support\Facades\Textit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class bookController extends Controller
{

    public function getLastBookId()
    {
        $category = category::all();
        return view('admin.pages.addNewbook', compact('category'));
    }

    public function addNewBook(Request $request)
    {

        $request->validate([
            'bookName' => 'required',
            'book-desc' => 'required',
            'quantity' => 'required|integer',
            'authorName' => 'required',
            'categoryId' => 'required',
            'price' => 'required|integer',
        ]);

        if ($request->hasFile('file')) {

            $request->validate([
                'image' => 'mimes:jpeg,bmp,png' //validate image type
            ]);

            
            $imageName = time().'.'.$request->file->extension();  
            $request->file->move(public_path('book-images'), $imageName);

            $book = new Book;

            $category = category::where('categoryId',$request->categoryId)->first();
            if ($category) {
                $category->books_quantity = $category->books_quantity + 1;
                $category->save();
            }else{
                return back()->with('fail','Selected category wrong!');
            }

            $uppercase = strtoupper($category->categoryName);
            $firstLt = substr($uppercase, 0, 2);
            $statement = DB::select("SHOW TABLE STATUS LIKE 'books'");
            $nextId = $statement[0]->Auto_increment;
            $bookId = 'B|'.$firstLt.'|'.$nextId;

            $book->book_id = $bookId;
            $book->book_name = $request->input('bookName');
            $book->book_desc = $request->input('book-desc');
            $book->quantity = $request->input('quantity');
            $book->book_image = $imageName;
            $book->price = $request->price;
            $book->author_name = $request->input('authorName');
            $book->category_id = $request->input('categoryId');
            $res = $book->save();
            $res = true;
            if($res){
                return back()->with('success',$bookId);
            }else{
                return back()->with('fail','Something wrong');
            }
        }

    }

    public function adminBookList()
    {
        $books = Book::all();
        $category = category::all();
        return view('admin.pages.listedBook', compact('books','category'));
    }

    public function userBookList()
    {
        $books = Book::all();
        return view('books-gride-view', compact('books'));
    }

    public function welcomeNewBooks()
    {
        $books = Book::latest()->limit(4)->get();
        $bookcount = count(Book::all());
        $category = category::all();
        $ebookcount = count(ebook::all());

        return view('uvaHome', compact('books','category','bookcount','ebookcount'));
    }

    public function bookSearch(Request $request)
    {
        $books = Book::where('category_id', $request->category)->get();
        return view('books-gride-view', compact('books'));
    }


    public function qr(){
        return view('admin/test');
    }

    // randus changes --------------------------------------------------
    public function index()
    {
        $books = BookRequest::orderBy('created_at')->get();
        $approved = false;
        return view('admin.pages.borrowReq', compact('books'));
    }
    public function unapproved()
    {
        $books = BookRequest::orderBy('id' )->where('is_approved', 0)->get();
        $approved = false;
        return view('admin.pages.borrowReq', compact('books', 'approved'));
    }

    public function approved()
    {
        $books = BookRequest::orderBy('id')->where('is_approved', 1)->get();
        $approved = true;
        return view('admin.pages.borrowReq', compact('books', 'approved'));
    }
    
       
    public function approve($id)
    {
        $book = BookRequest::find($id);
        $books = Book::where('book_id',$book->book_id)->first();
        if (!is_null($book)) {
            if ($user = UserStudent::where('Stu_Id',$book->user_id)->first()) {
                if ($check = studentBorrows::where('User_Id',$book->user_id)->latest()->first()) {
                    if ($check->status == 0 || $check->status == 4 || $check->status == 5) {
                        $borrow = new student_borrow();
                        $borrow->Book_Id = $book->book_id;
                        $borrow->User_Id = $book->user_id;
                        $borrow->Book_Name = $book->book_name;
                        $borrow->Borrow_Date = Carbon::now();
                        $borrow->Return_Date = Carbon::now()->addDays(7);
                        // $borrow->New_Return_Date = Carbon::now()->addDays(7);
                        $book->is_approved = 1;
                        $save = $book->save();
                        $borrow->save();
                        if ($save) {
                            $books->quantity = $books->quantity-1;
                            $books->save();

                            $noti = new notification();
                            $noti->memberid = $book->user_id;
                            $noti->notification = "You borrowed a book. Book ID: $borrow->Book_Id & Return Date $borrow->Return_Date";
                            $noti->job = "book borrow";
                            $noti->save();

                            //send
                            Textit::sms($user->TeleNum,'You borrowed a book.<br>Book ID: '.$borrow->Book_Id.' & Return Date '.$borrow->Return_Date); 
                            // using facade

                            return back()->with('success','Book issued! | Return Date: '.$borrow->Return_Date);
                        }else{
                            return back()->with('fail','Something wrong');
                        }
                    }else{
                        return back()->with('fail','Please return your previous book!');
                    }
                }else{
                    $borrow = new student_borrow();
                    $borrow->Book_Id = $book->book_id;
                    $borrow->User_Id = $book->user_id;
                    $borrow->Book_Name = $book->book_name;
                    $borrow->Borrow_Date = Carbon::now();
                    $borrow->Return_Date = Carbon::now()->addDays(7);
                    // $borrow->New_Return_Date = Carbon::now()->addDays(7);
                    $book->is_approved = 1;
                    $save = $book->save();
                    $borrow->save();
                    if ($save) {
                        $books->quantity = $books->quantity-1;
                        $books->save();

                        $noti = new notification();
                        $noti->memberid = $book->user_id;
                        $noti->notification = "You borrowed a book. Book ID: $borrow->Book_Id & Return Date $borrow->Return_Date";
                        $noti->job = "book borrow";
                        $noti->save();

                        //send
                        Textit::sms($user->TeleNum,'You borrowed a book. Book ID: '.$borrow->Book_Id.' & Return Date '.$borrow->Return_Date); 
                        // using facade

                        return back()->with('success','Book issued! | Return Date: '.$borrow->Return_Date);
                    }else{
                        return back()->with('fail','Something wrong');
                    }
                }
            }else if($user = UserStaff::where('staff_Id',$book->user_id)->first()) {
                if ($check = staff_borrow::where('User_Id',$book->user_id)->latest()->first()) {
                    if ($check->status == 0 || $check->status == 4 || $check->status == 5) {
                        $borrow = new staff_borrow();
                        $borrow->Book_Id = $book->book_id;
                        $borrow->User_Id = $book->user_id;
                        $borrow->Book_Name = $book->book_name;
                        $borrow->Borrow_Date = Carbon::now();
                        $borrow->Return_Date = Carbon::now()->addDays(14);
                        // $borrow->New_Return_Date = Carbon::now()->addDays(14);
                        $book->is_approved = 1;
                        $save = $book->save();
                        $borrow->save();

                        if ($save) {
                            $books->quantity = $books->quantity-1;
                            $books->save();

                            $noti = new notification();
                            $noti->memberid = $book->user_id;
                            $noti->notification = "You borrowed a book. Book ID: $borrow->Book_Id & Return Date $borrow->Return_Date";
                            $noti->job = "book borrow";
                            $noti->save();

                        //send
                        Textit::sms($user->TeleNum,'You borrowed a book. Book ID: '.$borrow->Book_Id.' & Return Date '.$borrow->Return_Date); 
                        // using facade

                            return back()->with('success','Book issued! | Return Date: '.$borrow->Return_Date);
                        }else{
                            return back()->with('fail','Something wrong');
                        }
                    }else{
                        return back()->with('fail','Please return your previous book!');
                    }
                }else{
                    $borrow = new staff_borrow();
                    $borrow->Book_Id = $book->book_id;
                    $borrow->User_Id = $book->user_id;
                    $borrow->Book_Name = $book->book_name;
                    $borrow->Borrow_Date = Carbon::now();
                    $borrow->Return_Date = Carbon::now()->addDays(14);
                    // $borrow->New_Return_Date = Carbon::now()->addDays(14);
                    $book->is_approved = 1;
                    $save = $book->save();
                    $borrow->save();

                    if ($save) {
                        $books->quantity = $books->quantity-1;
                        $books->save();

                        $noti = new notification();
                        $noti->memberid = $book->user_id;
                        $noti->notification = "You borrowed a book. Book ID: $borrow->Book_Id & Return Date $borrow->Return_Date";
                        $noti->job = "book borrow";
                        $noti->save();

                        //send
                        Textit::sms($user->TeleNum,'You borrowed a book. Book ID: '.$borrow->Book_Id.' & Return Date '.$borrow->Return_Date); 
                        // using facade

                        return back()->with('success','Book issued! | Return Date: '.$borrow->Return_Date);
                    }else{
                        return back()->with('fail','Something wrong');
                    }
                }
            }else{
                return back()->with('fail','Something wrong');
            }
        }
    }    

       
    public function unapprove($id)
    {
        
        $book = BookRequest::where('id', $id)->first();
        if (!is_null($book)) {
            $book->is_approved = 2;
            $book->save();
        }

        // $books = Book::where('book_id', $id)->first();
        // if (!is_null($books)) {
        //     $books->status = 0;
        //     $books->save();
        // }

        $noti = new notification();
        $noti->memberid = $book->user_id;
        $noti->notification = "You borrow request canceled. Please meet librarian";
        $noti->job = "book borrow requests";
        $noti->save();

        if ($user = UserStaff::where('staff_Id',$book->user_id)->first()) {
            
        }else{
            $user = UserStudent::where('Stu_Id',$book->user_id)->first();
        }

        //send
        Textit::sms($user->TeleNum,'You borrow request canceled.<br>Please meet librarian'); 
        // using facade

        // session()->flash('success', 'Book has been unapproved !!');
        return back()->with('fail', 'Book has been unapproved !');
    }

    public function borrowConfirm($id)
    {
        $book = Book::where('book_id', $id)->first();
        return view('admin.pages.borrow-confirm', compact('book'));
    }

    public function issuedBook()
    {
        $books = studentBorrows::orderBy('id', 'asc')->get();
        $staff_books = staff_borrow::orderBy('id', 'asc')->get();
        return view('admin.pages.issuedBooks', compact('books','staff_books'));
    }

    public function adminreturnBook($type,$id)
    {
        if ($type == 'student') {
            $book = studentBorrows::find($id);

            if (Carbon::now()->gt($book->Return_Date)) {
                return back()->with('fail','This is late return, please select late return option!');
            }else{
                $book->status = 0;
                $book->Return_Date = Carbon::now();
                // $book->New_Return_Date = Carbon::now();
                $book->save();
    
                $data = Book::where('book_id', $book->Book_Id)->first();
                $data->quantity = $data->quantity + 1;
                $data->save();
    
                $noti = new notification();
                $noti->memberid = $book->User_Id;
                $noti->notification = "You returned $book->Book_Id book.";
                $noti->job = "book return";
                $noti->save();

                if ($user = UserStaff::where('staff_Id',$book->User_Id)->first()) {
            
                }else{
                    $user = UserStudent::where('Stu_Id',$book->User_Id)->first();
                }
        
                //send
                Textit::sms($user->TeleNum,'You returned '.$book->Book_Id.' book.'); 
                // using facade
    
                return back()->with('success','Book returned!');
            }

        }else if ($type == 'staff') {
            $book = staff_borrow::find($id);
            $book->status = 0;
            $book->Return_Date = Carbon::now();
            // $book->New_Return_Date = Carbon::now();
            $book->save();
            
            $data = Book::where('book_id', $book->Book_Id)->first();
            $data->quantity = $data->quantity + 1;
            $data->save();

            $noti = new notification();
            $noti->memberid = $book->User_Id;
            $noti->notification = "You returned $book->Book_Id book.";
            $noti->job = "book return";
            $noti->save();;

            if ($user = UserStaff::where('staff_Id',$book->User_Id)->first()) {
            
            }else{
                $user = UserStudent::where('Stu_Id',$book->User_Id)->first();
            }
    
            //send
            Textit::sms($user->TeleNum,'You returned '.$book->Book_Id.' book.');
            // using facade

            return back()->with('success','Book returned!');
        }else{
            return back()->with('fail','Something wrong');
        }

    }

    public function lateReturn(Request $req)
    {
        if ($req->type == 'student') {
            if ($book = studentBorrows::find($req->id)) {
                $book->status = 5;
                $book->Return_Date = Carbon::now();
                // $book->New_Return_Date = Carbon::now();
                $book->save();

                if ($data = Book::where('book_id', $book->Book_Id)->first()) {
                    $data->quantity = $data->quantity + 1;
                    $data->save();

                    $fine = new studentFine();
                    $fine->type = "late return";
                    $fine->User_Id = $book->User_Id;
                    $fine->Book_Id = $book->Book_Id;
                    $fine->desc = "pay for late return. late return date is ".$req->today." & ".$req->daycount." days late";
                    $fine->Total_fine = $req->fine;
                    $res = $fine->save();

                    $noti = new notification();
                    $noti->memberid = $book->User_Id;
                    $noti->notification = "You late returned ".$book->Book_Id." book. Total Fine ".$fine->Total_fine;
                    $noti->job = "book return";
                    $noti->save();

                   
                    $user = UserStudent::where('Stu_Id',$book->User_Id)->first();
            
                    //send
                    Textit::sms($user->TeleNum,"You late returned ".$book->Book_Id." book. Total Fine ".$fine->Total_fine); 
                    // using facade

                    return back()->with('success',"You late returned ".$book->Book_Id." book. Total Fine ".$fine->Total_fine);
                }else{
                    return back()->with('fail','Book not found!');
                }
            }else{
                return back()->with('fail','Something wrong');
            }

        }else if ($req->type == 'staff') {

            if ($book = staff_borrow::find($req->id)) {
                $book->status = 5;
                $book->Return_Date = Carbon::now();
                // $book->New_Return_Date = Carbon::now();
                $book->save();
                
                if ($data = Book::where('book_id', $book->Book_Id)->first()) {
                    $data->quantity = $data->quantity + 1;
                    $data->save();

                    $fine = new staff_fine();
                    $fine->type = "late return";
                    $fine->User_Id = $book->User_Id;
                    $fine->Book_Id = $book->Book_Id;
                    $fine->desc = "pay for late return. late return date is ".$req->today." & ".$req->daycount." days late";
                    $fine->Total_fine = $req->fine;
                    $fine->save();

                    $noti = new notification();
                    $noti->memberid = $book->User_Id;
                    $noti->notification = "You late returned ".$book->Book_Id." book. Total Fine ".$fine->Total_fine;
                    $noti->job = "book return";
                    $noti->save();

                    $user = UserStaff::where('staff_Id',$book->User_Id)->first();
            
                    //send
                    Textit::sms($user->TeleNum,"You late returned ".$book->Book_Id." book. Total Fine ".$fine->Total_fine); 
                    // using facade

                    return back()->with('success','Book returned!');
                }else{
                    return back()->with('fail','Book not found!');
                }
            }else{
                return back()->with('fail','Something wrong');
            }
        }else{
            return back()->with('fail','Something wrong');
        }

    }

    public function missingBook($type,$id)
    {
        $books = Book::where('book_id', $id)->first();
        return view('admin.pages.payForBook', compact('books'));
    }

    public function editBook($id)
    {
        $books = Book::where('book_id',$id)->first();
        return view('admin.pages.addNewBook', compact('books'));
    }

    public function updateBook(Request $request)
    {
        $request->validate([
            'bookName'=>'required',
            'book-desc'=>'required',
            'authorName'=>'required',
        ]);

        $book = Book::where('book_id', $request->get('bookid'))->first();
        $book->book_name = $request->get('bookName');
        $book->book_desc = $request->get('book-desc');
        if ($request->quantity) {
            $book->quantity = $book->quantity + $request->get('quantity');
        }
        if($request->bookprice){
            $book->price = $request->get('bookprice');
        }
        $book->author_name = $request->get('authorName');
        $res = $book->save();
        if($res){
            return redirect()->route('admin.book.list')->with('success','Book updated!');
        }else{
            return back()->with('fail','Something wrong');
        }
    }

    public function removeBook($id)
    {
        $book = Book::find($id);
        $res = $book->delete();
        if($res){
            return back()->with('success','Book removed!');
        }else{
            return back()->with('fail','Something wrong');
        }
    }

    public function damagebook(Request $request)
    {
        $book = Book::find($request->id);
        if ($request->quantity < $book->quantity) {
            $book->is_damaged = 1;
            $book->quantity = $book->quantity-$request->quantity;
            $book->damaged_quantity = $book->damaged_quantity+$request->quantity;
            $res = $book->save();
            if($res){
                return back()->with('success','Book added to damage!');
            }else{
                return back()->with('fail','Something wrong');
            }
        }else{
            return back()->with('fail','You entered quantity is greater than from book quantity!');
        }
        
    }

    public function viewdamagebooks()
    {
        $books = Book::where('is_damaged',1)->get();
        return view('admin.pages.damagedBooks', compact('books'));
    }

    public function renewbook(Request $req)
    {
        $book = Book::find($req->id);
        if ($book->damaged_quantity >= $req->quantity) {
            $book->damaged_quantity = $book->damaged_quantity - $req->quantity;
            // $book->quantity = $book->quantity+1;
            if ($book->damaged_quantity == 0) {
                $book->is_damaged = 0;
            }
            $res = $book->save();
            if($res){
                return back()->with('success','Book removed from damage details!');
            }else{
                return back()->with('fail','Something wrong');
            }
        }else{
            return back()->with('fail','Entered damage count is not match!');
        }
    }

    public function adminissueBook(Request $request)
    {
        $book = Book::where('book_id',$request->bookid)->first();
        if ($book) {
            if ($book->quantity > 0) {
                if ($user = UserStudent::where('Stu_Id',$request->userid)->first()) {
                    if ($check = studentBorrows::where('User_Id',$request->userid)->latest()->first()) {
                        if ($check->status == 1) {
                            return back()->with('fail','Please return your previous book!');
                        }else{
                            $borrow = new student_borrow();
                            $borrow->Book_Id = $request->bookid;
                            $borrow->User_Id = $request->userid;
                            $borrow->Book_Name = $book->book_name;
                            $borrow->Borrow_Date = Carbon::now();
                            $borrow->Return_Date = Carbon::now()->addDays(7);
                            // $borrow->New_Return_Date = Carbon::now()->addDays(7);
                            if ($borrow->save()) {
                                $book->quantity = $book->quantity-1;
                                $book->save();
    
                                $noti = new notification();
                                $noti->memberid = $request->userid;
                                $noti->notification = "You borrowed a book. Book ID: $borrow->Book_Id & Return Date $borrow->Return_Date";
                                $noti->job = "book borrow";
                                $noti->save();

                                //send
                                Textit::sms($user->TeleNum,'You borrowed a book. Book ID: '.$borrow->Book_Id.' & Return Date '.$borrow->Return_Date); 
                                // using facade
    
                                return back()->with('success','Book issued! | Return Date: '.$borrow->Return_Date);
                            }else{
                                return back()->with('fail','Something wrong');
                            }
                        }
                    }else{
                        $borrow = new student_borrow();
                        $borrow->Book_Id = $request->bookid;
                        $borrow->User_Id = $request->userid;
                        $borrow->Book_Name = $book->book_name;
                        $borrow->Borrow_Date = Carbon::now();
                        $borrow->Return_Date = Carbon::now()->addDays(7);
                        // $borrow->New_Return_Date = Carbon::now()->addDays(7);
                        if ($borrow->save()) {
                            $book->quantity = $book->quantity-1;
                            $book->save();
    
                            $noti = new notification();
                                $noti->memberid = $request->userid;
                                $noti->notification = "You borrowed a book. Book ID: $borrow->Book_Id & Return Date $borrow->Return_Date";
                                $noti->job = "book borrow";
                                $noti->save();

                            //send
                            Textit::sms($user->TeleNum,"You borrowed a book. Book ID: ".$borrow->Book_Id." & Return Date ".$borrow->Return_Date); 
                            // using facade
    
                            return back()->with('success','Book issued! | Return Date: '.$borrow->Return_Date);
                        }else{
                            return back()->with('fail','Something wrong');
                        }
                    }
                }else if($user = UserStaff::where('staff_Id',$request->userid)->first()) {
                    if ($check = staff_borrow::where('User_Id',$request->userid)->latest()->first()) {
                        if ($check->status == 1) {
                            return back()->with('fail','Please return your previous book!');
                        }else {
                            $borrow = new staff_borrow();
                            $borrow->Book_Id = $request->bookid;
                            $borrow->User_Id = $request->userid;
                            $borrow->Book_Name = $book->book_name;
                            $borrow->Borrow_Date = Carbon::now();
                            $borrow->Return_Date = Carbon::now()->addDays(14);
                            // $borrow->New_Return_Date = Carbon::now()->addDays(14);
                            if ($borrow->save()) {
                                $book->quantity = $book->quantity-1;
                                $book->save();
    
                                $noti = new notification();
                                $noti->memberid = $request->userid;
                                $noti->notification = "You borrowed a book. Book ID: $borrow->Book_Id & Return Date $borrow->Return_Date";
                                $noti->job = "book borrow";
                                $noti->save();

                            //send
                            Textit::sms($user->TeleNum,"You borrowed a book. Book ID: ".$borrow->Book_Id." & Return Date ".$borrow->Return_Date); 
                            // using facade
    
                                return back()->with('success','Book issued! | Return Date: '.$borrow->Return_Date);
                            }else{
                                return back()->with('fail','Something wrong');
                            }
                        }
                    }else{
                        $borrow = new staff_borrow();
                        $borrow->Book_Id = $request->bookid;
                        $borrow->User_Id = $request->userid;
                        $borrow->Book_Name = $book->book_name;
                        $borrow->Borrow_Date = Carbon::now();
                        $borrow->Return_Date = Carbon::now()->addDays(14);
                        // $borrow->New_Return_Date = Carbon::now()->addDays(14);
                        if ($borrow->save()) {
                            $book->quantity = $book->quantity-1;
                            $book->save();
    
                            $noti = new notification();
                                $noti->memberid = $request->userid;
                                $noti->notification = "You borrowed a book. Book ID: $borrow->Book_Id & Return Date $borrow->Return_Date";
                                $noti->job = "book borrow";
                                $noti->save();

                            //send
                            Textit::sms($user->TeleNum,"You borrowed a book. Book ID: ".$borrow->Book_Id." & Return Date ".$borrow->Return_Date); 
                            // using facade
    
                            return back()->with('success','Book issued! | Return Date: '.$borrow->Return_Date);
                        }else{
                            return back()->with('fail','Something wrong');
                        }
                    }
                }else{
                    return back()->with('fail','You have entered wrong user ID!');
                }
            }else{
                return back()->with('fail','No available copies or this is damaged.');
            }
        }else{
            return back()->with('fail','you have entered wrong book ID!');
        }
        
    }

    public function extendDate($type,$id)
    {
        if ($type == 'student') {
            $book = studentBorrows::find($id);
            $book->New_Return_Date = Carbon::parse($book->Return_Date)->addDays(7);
            $book->status = 3;
            $book->save();

            $noti = new notification();
            $noti->memberid = $book->User_Id;
            $noti->notification = "$book->Book_Id Book return date extended another one week! New Return Date: $book->New_Return_Date";
            $noti->job = "extend return date";
            $noti->save();

            $user = UserStudent::where('Stu_Id',$book->User_Id)->first();
            
            //send
            Textit::sms($user->TeleNum, "Hi".$book->Book_Id." Book return date extended another one week! New Return Date: ".$book->New_Return_Date); 
            // using facade

            return back()->with('success','Book return date extended another one week! New Return Date: '.$book->New_Return_Date);

        }else if ($type == 'staff') {
            $book = staff_borrow::find($id);
            $book->New_Return_Date = Carbon::parse($book->Return_Date)->addDays(7);
            $book->status = 3;
            $book->save();

            $noti = new notification();
            $noti->memberid = $book->User_Id;
            $noti->notification = "$book->Book_Id Book return date extended another one week! New Return Date: $book->New_Return_Date";
            $noti->job = "extend return date";
            $noti->save();

            $user = UserStaff::where('staff_Id',$book->User_Id)->first();
            
            //send
            Textit::sms($user->TeleNum, "Hi".$book->Book_Id." Book return date extended another one week! New Return Date: ".$book->New_Return_Date); 
            // using facade

            return back()->with('success','Book return date extended another one week! New Return Date: '.$book->New_Return_Date);
        }else{
            return back()->with('fail','Something wrong');
        }
    }

    public function extendReturnDate($type,$id)
    {
        if ($type == 'student') {
            $data = studentBorrows::find($id);
            if ($data->status == 3) {
                return back()->with('fail','Return date already extended. Can not extend more!' );
            }else{
                $data->New_Return_Date = Carbon::parse($data->Return_Date)->addDays(7);
                $data->status = 3;
                $res = $data->save();

                if ($res) {
                    $noti = new notification();
                    $noti->memberid = $data->User_Id;
                    $noti->notification = "$data->Book_Id Book return date extended another one week! New Return Date: $data->New_Return_Date";
                    $noti->job = "extend return date";
                    $noti->save();

                    $user = UserStudent::where('Stu_Id',$data->User_Id)->first();
            
                    //send
                    Textit::sms($user->TeleNum, "Hi ".$data->Book_Id." Book return date extended another one week! New Return Date: ".$data->New_Return_Date); 
                    // using facade

                    return back()->with('success','Book return date extended another one week! New Return Date: '.$data->New_Return_Date);
                }else{
                    return back()->with('fail','Something wrong');
                }
            }
        }else{
            $data = staff_borrow::find($id);
            if ($data->status == 3) {
                return back()->with('fail','Return date already extended. Can not extend more!' );
            }else{
                $data->New_Return_Date = Carbon::parse($data->Return_Date)->addDays(7);
                $data->status = 3;
                $res = $data->save();

                if ($res) {
                    $noti = new notification();
                    $noti->memberid = $data->User_Id;
                    $noti->notification = "$data->Book_Id Book return date extended another one week! New Return Date: $data->New_Return_Date";
                    $noti->job = "extend return date";
                    $noti->save();

                    $user = UserStaff::where('staff_Id',$data->User_Id)->first();
            
                    //send
                    Textit::sms($user->TeleNum, "Hi ".$data->Book_Id." Book return date extended another one week! New Return Date: ".$data->New_Return_Date); 
                    // using facade

                    return back()->with('success','Book return date extended another one week! New Return Date: '.$data->New_Return_Date);
                }else{
                    return back()->with('fail','Something wrong');
                }
            }
        }
    }

    public function cancelReturnDate($type,$id)
    {
        if ($type == 'student') {
            $data = studentBorrows::find($id);
            $data->status = 1;
            $res = $data->save();
            if ($res) {
                
                $noti = new notification();
                $noti->memberid = $data->User_Id;
                $noti->notification = "Your extend return date request is canceled!";
                $noti->job = "extend return date";
                $noti->save();

                $user = UserStudent::where('Stu_Id',$data->User_Id)->first();
            
                //send
                Textit::sms($user->TeleNum, "Your extend return date request is canceled!"); 
                // using facade

                return back()->with('success','extend return date request is canceled!');
            }else{
                return back()->with('fail','Something wrong');
            }
        }else{
            $data = staff_fine::find($id);
            $data->status = 1;
            $res = $data->save();
            if ($res) {
                $noti = new notification();
                $noti->memberid = $data->User_Id;
                $noti->notification = "Your extend return date request is canceled!";
                $noti->job = "extend return date";
                $noti->save();

                $user = UserStaff::where('staff_Id',$data->User_Id)->first();
            
            //send
            Textit::sms($user->TeleNum, "Your extend return date request is canceled!"); 
            // using facade
                
                return back()->with('success','extend return date request is canceled!');
            }else{
                return back()->with('fail','Something wrong');
            }
        }
    }

    public function subjectBooks()
    {
        $id = "C|SU|13";
        $books = Book::where('category_id', $id)->get();
        return view('sub-books', compact('books'));
    }

    public function serachTimeRange(Request $req)
    {
        $req->validate([
            'start'=>'required',
            'end'=>'required',
        ]);

        $books = studentBorrows::whereBetween('Borrow_date', [$req->start, $req->end])->get();
        $staff_books = staff_borrow::whereBetween('Borrow_date', [$req->start, $req->end])->get();
        return view('admin.pages.issuedBooks', compact('books','staff_books'));
    }

    public function searchIssueBook(Request $req)
    {
        $req->validate([
            'bookid'=>'required',
        ]);

        $books = studentBorrows::where('book_id', $req->bookid)->get();
        $staff_books = staff_borrow::where('book_id', $req->bookid)->get();
        return view('admin.pages.issuedBooks', compact('books','staff_books'));
    }

    public function searchBookDetails(Request $req)
    {
        $req->validate([
            'bookid'=>'required',
        ]);

        $books = Book::where('book_id', $req->bookid)->get();
        return view('admin.pages.listedBook', compact('books'));
    }
}
