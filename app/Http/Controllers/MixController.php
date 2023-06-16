<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MixController extends Controller
{
    public function firstPage():RedirectResponse{
        if (auth()->check()){
            if (auth()->user()->role=='mudir')
                return redirect()->route('mudir-themes');
            elseif (auth()->user()->role=='sifat')
                return redirect()->route('sifat-bolimi-statistika');
            elseif (auth()->user()->role=='teacher')
                return redirect()->route('themes');
            elseif (auth()->user()->role=='super')
                return redirect()->route('mudirlar');
        }
        return redirect()->route('student-themes');
    }
    public function examples():View{
        return view('admin.examples');
    }
    public function profile():View{
        $user=auth()->user();
        return view('admin.all_profile',compact('user'));
    }
    public function updateProfile(Request $request,User $user):RedirectResponse{
        $request->validate([
            'name'=>'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->save();
        return redirect()->back()->with('msg','Muvaffaqiyatli yangilandi');
    }
    public function updatePassword(Request $request,User $user):RedirectResponse{
        $request->validate([
            'password'=>'required|string',
            'password_confirmation'=>'required|string|same:password',
        ]);
        $user->password=Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('msg','Muvaffaqiyatli yangilandi');
    }

}
