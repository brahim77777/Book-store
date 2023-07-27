<?php

namespace App\Http\Controllers;

use App\Models\Category;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use MongoDB\Driver\Session;

class CategoriesController extends Controller
{
    public function index(){
        $categories = Category::all()->sortBy('name');
        return view('admin.categories.index' , compact('categories'));
    }
    public function create(){
        return view('admin.categories.create');
    }
    public function store(Request $request){
        $this->validate($request , ['name' => 'required']);
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description ;
        $category->save();

        session()->flash('flash_message' , 'تم اضافة التصنيف بنجاح');
        return redirect(route('categories.index'));
    }
    public function edit(Category $category){
        return view('admin.categories.edit' , compact('category'));
    }
    public function update(Request $request , Category $category){
        $this->validate($request , ['name' => 'required']);
        $category->name = $request->name;
        $category->description = $request->description ;
        $category->save();

        session()->flash('flash_message' , 'تم تعديل التصنيف بنجاح');
        return redirect(route('categories.index'));
    }

    public function destroy(Category $category){
        $category->delete();
        session()->flash('flash_message' , 'تم حذف التصنيف بنجاح');
        return redirect(route('categories.index'));
    }

    public function result(Category $category){
        $books = $category->books()->paginate(12);
        $title = 'الكتب التابعة للتصنيف : '.$category->name ;
        return view('gallery' , compact('books' , 'title') );

    }

    public function list(){
        $categories = Category::all()->sortBy('name');
        $title = 'التصنيفات';
        return view('categories.index', compact('categories', 'title'));
    }

    public function search(Request $request){
        $categories = Category::where('name' , 'like' , "%{$request->term}%")->get()->sortBy('name');
        $title = 'نتائج البحث عن : '.$request->term ;
        return view('categories.index' , compact('categories' , 'title'));

    }
}
