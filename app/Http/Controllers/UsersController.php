<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(){
        $users  = User::all();
        return view('admin.users.index' , compact('users'));
    }
    public function create(Request $request){

    }
    public function update(Request $request , User $user){
        $user->administration_level = $request->role;
        $user->save();
        session()->flash('flash_message' , 'تم تعديل صلاخيات المستخدم بنجاح');

        return redirect(route('users.index'));
    }
    public function destroy(User $user){
        $user->delete();

        session()->flash('flash_message' , 'تم حذف المستخدم بنجاح');
        return redirect(route('users.index'));
    }


}
