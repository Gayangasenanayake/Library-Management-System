<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\addebookController;
use App\Http\Controllers\addMemberController;
use App\Http\Controllers\AdduserController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\ebookviewController;
use App\Http\Controllers\fileUploadController;
use App\Http\Controllers\FineViewController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\stuProfileController;
use App\Http\Controllers\timeTableController;
use App\Http\Controllers\userController;
use App\Http\Controllers\userListController;
use App\Http\Controllers\UserOperation;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LoginHomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\staffBrrowController;
use App\Http\Controllers\staffFineController;
use App\Http\Controllers\staffProfileController;
use App\Http\Controllers\stuBrrowController;
use App\Http\Controllers\stuFineController;
use App\Http\Controllers\testController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () { 
//     return view('uvaHome');
// });

Route::get('/',[bookController::class, 'welcomeNewBooks'])->name('user.welcome');

//mines---------------------------------------------------------------------------------------------------------
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function(){
    Route::get('/', [timeTableController::class, 'index'])->name('admin.panel');
    Route::get('/test',[bookController::class, 'qr']);
    Route::post('/newBook',[bookController::class, 'addNewBook'])->name('book.add_newbook');
    Route::view('/addNewCategory','admin.pages.addNewCategory')->name('admin.addNewCategory');
    Route::post('/addedNewCategory',[categoryController::class, 'addCategory'])->name('admin.add.category');
    Route::get('/editCategory/{id}',[categoryController::class, 'editcategory'])->name('admin.edit.category');
    Route::post('/updateCategory',[categoryController::class, 'updateCategory'])->name('update.category');
    Route::get('/removeCategory/{id}',[categoryController::class, 'removeCategory'])->name('admin.remove.category');

});
Route::get('/viewCategories',[categoryController::class, 'viewCategory'])->name('admin.view.category');

// Route::get('/admin', [timeTableController::class, 'index']);
Route::get('/listed-Books',[bookController::class, 'adminBookList'])->name('admin.book.list');
Route::get('/addBook',[bookController::class, 'getLastBookId'])->name('admin.addbook.page');
Route::get('/editBook/{id}',[bookController::class,'editBook'])->name('admin.edit.book');
Route::post('/updateBook',[bookController::class, 'updateBook'])->name('book.update.book');
Route::get('/removebook/{id}',[bookController::class, 'removeBook'])->name('admin.remove.book');
Route::post('/damagebook',[bookController::class, 'damagebook'])->name('admin.add.damage');
Route::get('/damaged-Books',[bookController::class, 'viewdamagebooks'])->name('admin.view.damage.book');
Route::post('/renewbook',[bookController::class, 'renewbook'])->name('admin.renew');
Route::post('/adminissueBook',[bookController::class, 'adminissueBook'])->name('admin.issue.book');

Route::view('/virtual-library','ebook');
Route::view('/issued-Books','admin/pages/issuedBooks');
// Route::view('/borrow-req-Books','admin/pages/borrowReq');
// Route::view('/user-requests','admin/pages/userRegiReq');

Route::get('/books-gride',[bookController::class, 'userBookList'])->name('user.book.view'); 
Route::post('/search-book',[bookController::class, 'bookSearch'])->name('book.search');

Route::get('/subject-books',[bookController::class, 'subjectBooks'])->name('subject.book');
Route::get('/userDetails',[userController::class,'viewDate'])->name('admin.view.user.detailss');
Route::get('/addUser',[userController::class,'getUser'])->name('admin.add.user');
Route::view('/issueNewBook','admin/pages/issueNewBook');

// randulas parts---------------------------------------------------------------------------------------------------------
Route::get('/borrow-req-Books', [bookController::class,'index'])->name('admin.books.index');
Route::get('/user-requests',[userController::class,'userRequest'])->name('user.request');
Route::get('/unapproved', [bookController::class,'unapproved'])->name('admin.books.unapproved');
Route::get('/approved',[bookController::class,'approved'])->name('admin.books.approved');
Route::post('/approve/{id}', [bookController::class,'approve'])->name('admin.books.approve');
Route::post('/unapprove/{id}',[bookController::class,'unapprove'])->name('admin.books.unapprove');
Route::post('/books-borrow-req',[dashboardController::class,'requestBook'])->name('books.borrow.request');
Route::post('/borrow-req-Books',[dashboardController::class,'borrowBook'])->name('books.borrow.sent');
Route::get('/borrow-confirm/{id}', [bookController::class,'borrowConfirm'])->name('admin.books.borrowConfirm');
Route::get('/issued-Books',[bookController::class,'issuedBook'])->name('admin.books.issued');
Route::get('/return-book/{type}/{id}',[bookController::class,'adminreturnBook'])->name('admin.books.return');
// Route::get('/missing-book/{type}/{id}',[bookController::class,'missingBook'])->name('admin.books.missing');
Route::get('/extendDate/{type}/{id}',[bookController::class,'extendDate'])->name('admin.extend.date');
Route::post('/late-return-book',[bookController::class,'lateReturn'])->name('late.return');
Route::post('/issued-Books-time-range',[bookController::class,'serachTimeRange'])->name('admin.search.time.range');


// chiris parts------------------------------------------------------------------------------------------------------------
// Route::view('/staff','staff/StaffProfile');
Route::get('/borrow-Detail',[staffBrrowController::class,'fetchBorrowBooks'])->name('staff_borrow_books');
Route::get('/extend-Return',[staffBrrowController::class,'extendsBorrowBooks'])->name('staff_extends_books');
Route::get('/fine-Details',[staffFineController::class,'fetchBookFines'])->name('staff_book_fines');
Route::get('/Staff-Extend-Return-Date/{id}',[staffBrrowController::class,'extendsRequest'])->name('staff.extends.books'); 

Route::get('/user/{memberid}',[stuProfileController::class,'showData'])->name('user.profile');

Route::post('/SaveEditedData',[stuProfileController::class,'stuDataSave']);
Route::get('/Stu-borrow-Detail',[stuBrrowController::class,'fetchBorrowBooks'])->name('borrow_books');
Route::get('/Stu-fine-Details',[stuFineController::class,'fetchBookFines'])->name('book_fines');
Route::get('/Stu-extend-Return',[stuBrrowController::class,'extendsBorrowBooks'])->name('extends_books');
Route::get('/Asking-Extend-Return-Date/{id}',[stuBrrowController::class,'extendsRequest']);
Route::post('/stuSavePassword',[stuProfileController::class,'changePassword'])->name('student.change.password');
Route::post('/staffSaveEditedData',[staffProfileController::class,'staffDataSave']);
Route::post('/staffSavePassword',[staffProfileController::class,'changePassword']);


//------------------------------chethanas parts------------------------------------------------------------------------------------------------------------

Auth::routes();
// Route::get('forgot-password', [UserController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/reset-pin', [CustomAuthController::class, 'forgotPasswordValidate']);
Route::post('/forgot-password', [CustomAuthController::class, 'resetPassword'])->name('forgot-password');
Route::post('/reset-password', [CustomAuthController::class, 'updatePassword'])->name('reset-password');

Route::get('/home', [LoginHomeController::class, 'index'])->name('home');

Route::get('/admin/home', [timeTableController::class, 'index'])->name('admin.home')->middleware('is_admin');


//Route::get('/login',[CustomAuthController::class,'login']);
Route::get('/registration',[CustomAuthController::class,'registration'])->name('registration');
Route::get('/staffregistration',[CustomAuthController::class,'staffregistration'])->name('staffRegistration');;
Route::post('/register-user',[CustomAuthController::class,'registerUser'])->name('register-user');
Route::post('/register-staffuser',[CustomAuthController::class,'registerStaffUser'])->name('register-staffuser');

Route::get('/user-list',[AdduserController::class,'userList'])->name('user.list');
Route::get('/edit-user/{id}',[AdduserController::class,'editUser'])->name('user.edit');
Route::get('/delete-user/{id}',[AdduserController::class,'deleteUser'])->name('user.delete');
// Route::post('/update-user',[AdduserController::class,'updateUser'])->name('user.update');
Route::get('/add-user',[AdduserController::class,'addUser'])->name('add.user');
Route::post('/add-user',[AdduserController::class,'saveUser'])->name('save.user');

Route::get('/send-user/{id}',[AdduserController::class,'sendUser'])->name('send.user');
Route::post('/send-user',[AdduserController::class,'sendUserSave'])->name('insert.user');

//-----------------------------------------gayangas part----------------------------------------------------------------------------------------------

Route::get('/admin/pages/ListedFineStudent',[FineViewController::class,'getfine'])->name('list.fine');
Route::post('/addfine',[FineViewController::class,'addfine'])->name('add.fine');
Route::get('/admin/removeFineDetails/{id}/{type}',[FineViewController::class,'removeFine'])->name('admin.fine.remove');


// new
Route::get('/user-approved/{id}',[userController::class,'userApprove'])->name('user.approve');
Route::get('/user-unapproved/{id}',[userController::class,'userUnapprove'])->name('user.unapprove');
Route::get('/student-remove/{id}',[userController::class,'studentRemove'])->name('student.remove');
Route::get('/user-update/{id}',[userController::class,'userUpdate'])->name('user.update');
Route::post('/student-updated',[userController::class,'studentUpdated'])->name('admin-st-update');
Route::post('/admin-register-user',[userController::class,'adminRegisterUser'])->name('admin-register-user');
Route::post('/admin-register-staffuser',[userController::class,'adminRegisterStaffUser'])->name('admin-register-staffuser');
Route::get('/staff-remove/{id}',[userController::class,'staffremove'])->name('staff.remove');
Route::get('/read-notification/{id}',[NotificationController::class,'Notificationread'])->name('notification.read');
Route::post('/admin-register-staffuser',[userController::class,'adminRegisterStaffUser'])->name('admin-register-staffuser');
Route::post('/admin/updateTimetable',[timeTableController::class,'updateTimetable'])->name('admin.update.timetable');
Route::post('/adminProfileUpdate',[AccountController::class,'updateAdmin'])->name('admin.update.Profile');
Route::get('/acceptExtend/{type}/{id}',[bookController::class,'extendReturnDate'])->name('admin.accept.extend');
Route::get('/cancelExtend/{type}/{id}',[bookController::class,'cancelReturnDate'])->name('admin.cancel.extend');

Route::get('/ebook-view',[ebookviewController::class,'index'])->name('ebook.view');
Route::view('/inserteBook','admin/pages/insertebook');
Route::post('/inserteBook',[addebookController::class, 'addNeweBook'])->name('admin.inserteBook');
Route::get('/listedEbooks',[ebookviewController::class,'viewEbooks'])->name('admin.ebooks.view');
Route::get('/removeEbook/{id}',[ebookviewController::class,'removeEbook'])->name('admin.remove.ebook');

Route::get('/delete-notification/{id}',[NotificationController::class,'Notificationdelete'])->name('notification.delete');
Route::post('/addNewAdmin',[AccountController::class,'addNewAdmin'])->name('add.new.admin');

Route::post('/search-issued-Book',[bookController::class,'searchIssueBook'])->name('admin.search.issuedbook');
Route::post('/search-Book-details',[bookController::class,'searchBookDetails'])->name('admin.search.book.details');

// virtual view
Route::view('/virtual-Library','virtualLibrary');

Route::view('/contact','contact');
Route::post('/contact-us',[testController::class,'contactus'])->name('contact.us');

Route::post('/contact-reply',[testController::class,'contactReply'])->name('contact.reply');











