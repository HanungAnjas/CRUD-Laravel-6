<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class LoginController extends Controller
{
    public function login(){
        return view('login');
    }

    public function loginuser(Request $request){
        if(Auth::attempt($request->only('email','password'))){
            return redirect('/pegawai');
        }

        return \redirect('login');
    }

    public function register(){
        return view('register');
    }

    public function registeruser(Request $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'remember_token' => Str::random(60),
        ]);

        event(new Registered($user));
        
        Auth::login($user);

        return redirect('/email/verify');
    }

    public function logout(){
        Auth::logout();
        return \redirect('login');
    }
}
