<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
Route::view('/', 'posts.index')->name('home');
Route::view('/register', 'auth.register')->name('register');
Route::view('/login','auth.login')->name('login');


Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);