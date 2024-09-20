<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Register
    public function register(Request $request){
       // validation
       $fields = $request->validate([
        'username' => ['required','max:255'],
        'email'=>['required','max:255','email','unique:users'],
        'password'=>['required','min:8','confirmed']

       ]);

       // Register
       $user= User::create($fields);

       // Login 
       Auth::login($user);

       // Redirect
       return redirect()->route('home');


    }

    // Login
    public function login(Request $request){

        // Validation
        $fields = $request->validate([
            'email'=>['required','max:255','email'],
            'password'=>['required']

        ]);

        // Login
        if(Auth::attempt($fields,$request->remember)){
            return redirect()->intended();
        }

        // Failed  to login  and redirect back with error message
        return back()->withErrors(['failed'=>'Incorrect email or password']);

    }
}
