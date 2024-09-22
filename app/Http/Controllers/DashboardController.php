<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Loan;
use App\Models\User;



class DashboardController extends Controller // implements HasMiddleware
{
    // public static function middleware(): array
    // {
    //     return [
    //         'auth',
    //     ];
    // }
    public function index(){

        $bookCount = Book::count();
        $genreCount = Genre::count();
        $activeLoansCount=Loan::where('loan_status','active')->count();
        $usersCount = User::count();
        $adminsCount = User::where('role','admin')->count();
        $studentsCount = User::where('role','student')->count();

        $data = [
            'bookCount' => $bookCount,
            'genreCount' => $genreCount,
            'activeLoansCount' => $activeLoansCount,
            'usersCount' => $usersCount,
            'adminsCount' => $adminsCount,
           'studentsCount' => $studentsCount,
        ];

        return view('users.dashboard',$data);
    }
}
