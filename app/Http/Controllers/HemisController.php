<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Theme;
use App\Providers\RouteServiceProvider;
use App\Services\HemisService;
use App\Services\ThemeService;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;

class HemisController extends Controller
{
    public function __construct()
    {
        $this->middleware(StartSession::class);
    }
    public function login(){

        if (session()->has('loggedin')) {
            return redirect()->route('process');
        }else{
            return view('hemis.login');
        }
    }

    public function loginUser(Request $request){
        $request->validate([
            'login'=>'required',
            'password'=>'required'
        ]);
        $credentials=[];
        if (str_contains($request->login, '@')) {
            $credentials = [
                'email' => $request->login,
                'password' => $request->password,
            ];
        }else {


            try {
                if (HemisService::login($request->login, $request->password)) {
                    return redirect()->route('process');
                }
            } catch (\Exception $exception) {
                return redirect()->route('login-student')->withErrors('Login yoki parol xato !');
            }
        }
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }
        return redirect()->back()->withErrors(['login' => 'Login yoki parol xato !']);

    }
    public function logout(){
        session()->flush();
        return redirect()->route('login-student');
    }
    public function profile(){
        try {
            HemisService::getMe();
            return view('admin.profile');
        }catch (\Exception $exception){
            return redirect()->route('login-student')->withErrors('Talaba ma\'lumotlarini olishda xatolik, iltimos qayta urinib ko\'ring !');
        }

    }



}
