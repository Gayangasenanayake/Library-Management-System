<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\addMemberController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\fileUploadController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\testController;
use App\Http\Controllers\timeTableController;
use App\Http\Controllers\userController;
use App\Http\Controllers\userListController;
use App\Http\Controllers\UserOperation;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\AdduserController;



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

//Route::get('/', function () {
//   return view('welcome');
//});

Route::get('/test',[testController::class, 'getData']); //this is for test


Route::get('/',[bookController::class, 'welcomeNewBooks'])->name('user.welcome');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function(){
    Route::get('/', [timeTableController::class, 'index']);
    Route::post('/newBook',[bookController::class, 'addNewBook'])->name('book.add_newbook');
});

// Route::get('/admin', [timeTableController::class, 'index']);
Route::get('/listed-Books',[bookController::class, 'adminBookList'])->name('admin.book.list');
Route::get('/addBook',[bookController::class, 'getLastBookId'])->name('admin.addbook.page');

Route::view('/profile','admin/profile');
Route::view('/damaged-Books','admin/pages/damagedBooks');
Route::view('/issued-Books','admin/pages/issuedBooks');
Route::view('/borrow-req-Books','admin/pages/borrowReq');
Route::view('/userDetails','admin/pages/usersDetails');
Route::view('/addUser','admin/pages/addNewuser');
Route::view('/issueNewBook','admin/pages/issueNewBook');
Route::view('/addCategory','admin/pages/addCategory');
Route::view('/listedCategories','admin/pages/listedCategories');
Route::view('/addAuthor','admin/pages/addNewAuthor');
Route::view('/listedAuthors','admin/pages/listedAuthors');

//user routes

Route::get('/books-gride',[bookController::class, 'userBookList'])->name('user.book.view');
Route::post('/search-book',[bookController::class, 'bookSearch'])->name('book.search');

Route::view('/ebooks','ebook');






Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//admin area
Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminIndex'])->name('admin.home')->middleware('is_admin');

//Route::get('/login',[CustomAuthController::class,'login']);
Route::get('/registration',[CustomAuthController::class,'registration']);
Route::get('/staffregistration',[CustomAuthController::class,'staffregistration']);
Route::post('/register-user',[CustomAuthController::class,'registerUser'])->name('register-user');
Route::post('/register-staffuser',[CustomAuthController::class,'registerStaffUser'])->name('register-staffuser');



Route::get('/user-list',[AdduserController::class,'userList'])->name('user.list');
Route::get('/edit-user/{id}',[AdduserController::class,'editUser'])->name('user.edit');
Route::get('/delete-user/{id}',[AdduserController::class,'deleteUser'])->name('user.delete');
Route::post('/update-user',[AdduserController::class,'updateUser'])->name('user.update');
Route::get('/add-user',[AdduserController::class,'addUser'])->name('add.user');
Route::post('/add-user',[AdduserController::class,'saveUser'])->name('save.user');


Route::get('/send-user/{id}',[AdduserController::class,'sendUser'])->name('send.user');
Route::post('/send-user',[AdduserController::class,'sendUserSave'])->name('insert.user');
