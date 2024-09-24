<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoanController;

use App\Http\Middleware\AdminMiddleware;

Route::redirect('/','books');

Route::resource('books',BookController::class);

Route::resource('genres',GenreController::class);

Route::get('/loans/user/{id}',[LoanController::class,'userBorrowed'])->name('userBorrowed');

Route::resource('loans',LoanController::class);

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


Route::middleware('auth')->group(function(){
   
    // Custom routes for updating user details and password
    Route::patch('/users/{id}/details',[UserController::class,'updateUserDetails'])->name('users.updateDetails');
    Route::patch('/users/{id}/password',[UserController::class,'updatePassword'])->name('users.updatePassword');

    // Route for editing the current authenticated user's profile
    Route::get('/users/profile',[UserController::class,'profile'])->name('users.profile');
    Route::get('/users/editMe', [UserController::class, 'editMe'])->name('users.editMe');
    Route::patch('/users/editMeDetalis',[UserController::class, 'updateMeDetalis'])->name('users.updateMeDetalis');
    Route::patch('/users/editMePassword',[UserController::class, 'updateMePassword'])->name('users.updateMePassword');

    // Resource routes for users (index, show, create, store, edit, update, destroy)
    Route::resource('users',UserController::class);

    
});











