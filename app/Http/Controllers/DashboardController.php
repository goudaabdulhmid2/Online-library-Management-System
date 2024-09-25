<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


use App\Models\Book;
use App\Models\Genre;
use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;



class DashboardController extends Controller
{

    public function index(Request $request){

        // CurrentUser
        $currentUser = Auth::user();

        $search = $request->input('search');

        // Check if user is admin or manager and load dashboard data accordingly
        if(Gate::allows('admin',$currentUser) || Gate::allows('manager',$currentUser)){
            $bookCount = Book::count();
            $booksAvliableToBorrowed = Book::where('quantity','>',0)->count();
            $genreCount = Genre::count();
            $borrowedBooksActiveCount = Loan::where('loan_status','active')->count();
            $usersCount = User::count();
            $adminsCount = User::where('role','admin')->count();
            $studentsCount = User::where('role','student')->count();

            $data = [
                'bookCount' => $bookCount,
                'genreCount' => $genreCount,
                'borrowedBooksActiveCount' => $borrowedBooksActiveCount,
                'booksAvliableToBorrowed' => $booksAvliableToBorrowed,
                'usersCount' => $usersCount,
                'adminsCount' => $adminsCount,
            'studentsCount' => $studentsCount,
            ];
        }
        // Load dashboard data for ٍ students
        else{
            $userBorrows = Loan::with(['user', 'book'])
            ->where('user_id', $currentUser->id)
            ->when($search, function($query, $search) {
                if (!empty($search)) {
                    return $query->whereHas('book', function ($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    });
                }
            })->orderBy('loan_status', 'asc')
            ->paginate(10);
         
            foreach ($userBorrows as $borrow) {
                $remainingDays = Carbon::now()->diffInDays(Carbon::parse($borrow->due_date));
                 $borrow->remainingDays = ceil($remainingDays);
            }
        
            $data = [
                'userBorrows' => $userBorrows,
            ];

            
        }

        return view('users.dashboard',$data);
    }
}
