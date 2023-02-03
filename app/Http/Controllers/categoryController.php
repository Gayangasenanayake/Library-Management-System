<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class categoryController extends Controller
{
    public function addCategory(Request $req)
    {
        $table = new category;
        $uppercase = strtoupper($req->categoryName);
        $firstLt = substr($uppercase, 0, 2);
        $statement = DB::select("SHOW TABLE STATUS LIKE 'categories'");
        $nextId = $statement[0]->Auto_increment;

        $category_id = 'C|'.$firstLt.'|'.$nextId;
        $table->categoryId = $category_id;
        $table->categoryName = $req->categoryName;
        $res = $table->save();
        if($res){
            return back()->with('success','Category added! Category ID: '.$category_id);
        }else{
            return back()->with('fail','Something wrong');
        }
        
    }

    public function viewCategory()
    {
        $categories = category::all();
        return view('admin.pages.viewCategories', compact('categories'));
    }

    public function editcategory($id)
    {
        $category = category::find($id);
        return view('admin.pages.addNewCategory', compact('category'));
    }

    public function updateCategory(Request $req)
    {
        $category = category::find($req->id);
        $category->categoryName = $req->categoryName;
        $res = $category->save();
        if($res){
            return redirect()->route('admin.view.category')->with('success','Category Updated');
        }else{
            return back()->with('fail','Something wrong');
        }
    }

    public function removeCategory($id)
    {
        $category = category::find($id);
        $res = $category->delete();
        if($res){
            return redirect()->route('admin.view.category')->with('remove','Category Removed!');
        }else{
            return back()->with('fail','Something wrong');
        }
    }
}
