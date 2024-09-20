<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;



Route::redirect('/','books');

Route::resource('books',BookController::class);

Route::middleware('guest')->group(function (){

Route::post('/register',[AuthController::class,'register']);
Route::view('/register', 'auth.register')->name('register');

Route::post('/login',[AuthController::class,'login']); 
Route::view('/login','auth.login')->name('login');
});

Route::middleware('auth')->group(function(){
    
Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

Route::post('/logout',[AuthController::class,'logout'])->name('logout');
});






