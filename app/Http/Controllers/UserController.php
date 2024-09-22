<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use  App\Http\Middleware\AdminMiddleware;

use App\Models\User;
use App\Models\Loan;


class UserController extends Controller  implements HasMiddleware
{
  
    public static function middleware(){

        return [
            new Middleware(AdminMiddleware::class)
        ];
    }

    public function index(Request $request)
    {
        // Get the current authenticated user
        $currentUser = Auth::user(); 

            // Retrieve the search query for user ID, if any
        $searchId = $request->input('search_id');

         // Check if the current user is a manager
        if (Gate::allows('manager', $currentUser)) { 
            
            $users = User::where('id', '!=', $currentUser->id);

            // if there search query
            if($searchId) {
                $users = $users->where('id', $searchId);
            }

            $users = $users->orderBy('role', 'desc')->paginate(10);
        }
        // Check if the current user is an admin and the user being viewed is a students
         elseif (Gate::allows('admin', $currentUser)) { 
            $users = User::where('role', 'student');

            // if there search query
            if($searchId) {
                $users = $users->where('id', $searchId);
            }

            $users = $users->paginate(10);
        } 
        //   If none of the conditions match, return unauthorized response
        else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        // Pass users
        return view('users.admin.index', compact('users','searchId'));
    }

    public function show($id)
    { 
        // Get the current authenticated user
        $currentUser = Auth::user();
        
       
        // Check if the current user is a manager
        if (Gate::allows('manager', $currentUser)) {
            $user = User::find($id);
            $borroweds = Loan::with('book')->where('user_id', $id)->orderBy('due_date', 'asc')->paginate(10);
        } 
        // Check if the current user is an admin and the user being viewed is not a manager
        elseif (Gate::allows('admin', $currentUser) && Gate::allows('isIdManager', $id)) {
            $user = User::find($id);
            $borroweds = Loan::with('book')->where('user_id', $id)->orderBy('due_date', 'asc')->paginate(10);
        } 
        // If none of the conditions match, return unauthorized response
        else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        // Pass both user and borrowed data to the view
        // dd($borroweds);
        return view('users.show', compact('user', 'borroweds'));
    }
    
}
