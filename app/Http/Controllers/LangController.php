<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LangController
{
    public function index($lang){
    	app()->setLocale($lang);
    	session()->put('lang',$lang);
    	return redirect()->back();
    }

    public function login(){
        return view('login');
    }

    public function loged(Request $request){
        $user=User::where('email',$request->email)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                session()->put('user',$user);
                session()->put('lang','en');
                return redirect('/home');
            }
        }
        return redirect('/');
    }

    public function logout(){
        session()->forget('user');
        session()->forget('lang');
        return redirect('/');
    }

    public function home(){
        return view('home');
    }
}
