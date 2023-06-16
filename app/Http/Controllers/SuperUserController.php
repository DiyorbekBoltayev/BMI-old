<?php

namespace App\Http\Controllers;

use App\Models\Kafedra;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperUserController extends Controller
{
    public function mudirlar(){
        $users=User::where('role','mudir')->get();
        return view('admin.super.mudirlar',compact('users'));
    }
    public function mudirCreate(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required | email | unique:users',
            'password'=>'required',
            'password_confirmation'=>'required | same:password',
            'kafedra_name'=>'required'
        ]);
        $a=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'mudir'
        ]);
        Kafedra::create([
            'name'=>$request->kafedra_name,
            'user_id'=>$a->id
        ]);
        return redirect()->back()->with('msg','Mudir muvaffaqiyatli yaratildi');
    }
    public function mudirDelete($id){
        $user=User::find($id);
        $user->delete();
        return redirect()->back()->with('msg','Mudir muvaffaqiyatli o`chirildi');
    }
    public function mudirUpdate(Request $request,$id){
        $request->validate([
            'name'=>'required',
            'email'=>'required | email',
            'password'=>'required',
            'password_confirmation'=>'required | same:password',
            'kafedra_name'=>'required'
        ]);
        $user=User::find($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();
        $kafedra=Kafedra::where('user_id',$user->id)->first();
        $kafedra->name=$request->kafedra_name;
        $kafedra->save();
        return redirect()->back()->with('msg','Mudir muvaffaqiyatli yangilandi');
    }
}
