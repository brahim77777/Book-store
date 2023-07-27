<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublishersController extends Controller
{
    public function index(){
        $publishers = Publisher::all();
        return view('admin.publishers.index' , compact('publishers'));
    }

    public  function  create(){
        return view('admin.publishers.create');
    }

    public function store(Request $request){
        $this->validate($request, ['name'=>'required']);
        $publisher = new Publisher();
        $publisher->name= $request->name;
        $publisher->address= $request->address;
        $publisher->save();

        session()->flash('flash_message' , 'تم اضافة ناشر جديد بنجاح');
        return redirect(route('publishers.index'));
    }
    public function edit(Publisher $publisher){
        return view('admin.publishers.edit' , compact('publisher'));
    }

    public function update(Request $request , Publisher $publisher){
        $this->validate($request, ['name'=>'required']);
        $publisher->name= $request->name;
        $publisher->address= $request->address;
        $publisher->save();

        session()->flash('flash_message' , 'تم تعديل الناشر جديد بنجاح');
        return redirect(route('publishers.index'));
    }

    public function destroy(Publisher $publisher){
        $publisher->delete();
        session()->flash('flash_message' , 'تم حذف الناشر جديد بنجاح');
        return redirect(route('publishers.index'));
    }


    public function result(Publisher $publisher){
        $books = $publisher->books()->paginate(12);
        $title = 'الكتب التابعة للناشر : '.$publisher->name ;
        return view('gallery' , compact('books' , 'title') );

    }

    public function list(){
        $publishers = Publisher::all()->sortBy('name');
        $title = 'الناشرون';
        return view('publishers.index', compact('publishers', 'title'));
    }

    public function search(Request $request){
        $publishers = Publisher::where('name' , 'like' , "%{$request->term}%")->get()->sortBy('name');
        $title = 'نتائج البحث عن : '.$request->term ;
        return view('publishers.index' , compact('publishers' , 'title'));

    }
}
