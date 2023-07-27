<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorsController extends Controller
{

    public function index(){
        $authors = Author::all();
        return view('admin.authors.index' , compact('authors'));
    }

    public function create(){
        return view('admin.authors.create');
    }
    public function store(Request $request){
        $this->validate($request , ['name'=>'required']);
        $author = new Author();
        $author->name = $request->name;
        $author->description = $request->description;
        $author->save();
        session()->flash('flash_message' , 'تم اضافة المؤلف بنجاح');

        return redirect(route('authors.index'));
    }

    public function edit(Author $author){
        return view('admin.authors.edit' , compact('author'));
    }

    public function  update(Request $request   , Author $author){
        $this->validate($request , ['name'=>'required']);
        $author->name= $request->name;
        $author->description= $request->description;

        $author->save();
        session()->flash('flash_message' , 'تم تعديل المؤلف بنجاح');

        return redirect(route('authors.index'));
    }

    public function destroy(Author $author){
        $author->delete();

        session()->flash('flash_message' , 'تم خذف المؤلف بنجاح');

        return redirect(route('authors.index'));
    }

    public function result(Author $author){
        $books = $author->books()->paginate(12);
        $title = 'كتب المؤلف : '.$author->name ;
        return view('gallery' , compact('books' , 'title') );

    }

    public function list(){
        $authors = Author::all()->sortBy('name');
        $title = 'المؤلفون ';
        return view('authors.index', compact('authors', 'title'));
    }

    public function search(Request $request){
        $authors = Author::where('name' , 'like' , "%{$request->term}%")->get()->sortBy('name');
        $title = 'نتائج البحث عن : '.$request->term ;
        return view('authors.index' , compact('authors' , 'title'));

    }
}
