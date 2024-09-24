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

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller  implements HasMiddleware
{
  
    public static function middleware(){

        return [
            new Middleware(AdminMiddleware::class, except: ['editMe','updateMeDetalis','updateMePassword','profile']),
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
            return redirect()->route('/')->with('error', 'Access denied. Only admins can perform this action.');
        }
        // Pass users
        return view('users.admin.index', compact('users','searchId'));
    }

    public function show($id){

    // Get the current authenticated user
    $currentUser = Auth::user();
    
    // Find the user by ID
    $userToShow = User::find($id); 

    

    // Check if the current user is a manager
    if (Gate::allows('manager', $currentUser)) {
        // Managers can view any user
        $borroweds = Loan::with('book')->where('user_id', $id)->orderBy('due_date', 'asc')->paginate(10);
    } 
     // Check if the current user is an admin and the user to edit is a student
    elseif (Gate::allows('admin', $currentUser) && $userToShow->role === 'student') {
        // Admins can only view students
        $borroweds = Loan::with('book')->where('user_id', $id)->orderBy('due_date', 'asc')->paginate(10);
    } 
    // If none of the conditions match, return unauthorized response
    else {
        return redirect('/users')->with('error', 'Access denied. Only admins can perform this action.');
    }

    // Pass both user and borrowed data to the view
    return view('users.show', compact('userToShow', 'borroweds'));
}


    public function edit($id){
        // Get the current authenticated user
        $currentUser = Auth::user();

        // Find the user by ID
        $userToShow = User::find($id); 
        
        // Check if the current user is a manager
        if(Gate::allows('manager', $currentUser)){
            $user =$userToShow; 
        }
        // Check if the current user is an admin and the user to edit is a student
        elseif(Gate::allows('admin',$currentUser) && $userToShow->role === 'student'){
            $user = $userToShow;
        }
        // If the user is not authorized, redirect with an error message
        else{
            return redirect('/users')->with('error', 'Access denied. Only admins can perform this action.');
        }

        
        return view('users.admin.edit', compact('user'));
    }


    public function updateUserDetails(Request $request,$id){
        // Get the current authenticated user
        $currentUser = Auth::user();
        
        // Get user 
        $userToUpdate =User::find($id);

        // Check if the current user is a manager
        if(Gate::allows('manager',$currentUser)){
            $user = $userToUpdate;
        }
        // Check if the current user is an admin and the user to update is a student
        elseif(Gate::allows('admin',$currentUser) && $userToUpdate->role ==='student'){
            $user = $userToUpdate;
        }
        // If the user is not authorized, redirect with an error message
        else{
            return redirect('/users')->with('error', 'Access denied. Only admins can perform this action.');
        }

        // Validate the request
        $request->validate([
            'username' => ['required','string','max:255'],
            'email' => ['required','email',
            Rule::unique('users')->ignore($user->id),
        ],
            'role' => ['nullable','string','in:student,admin']
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        if(Gate::allows('manager',$currentUser)){
            $user->role = $request->role;
        }
        
        $user->save();
        return redirect('/users')->with('success', 'User details updated successfully!');
    }

    Public function updatePassword(Request $request,$id){
        // get user 
        $userToUpdate = User::find($id);
        // Get the current authenticated user
        $currentUser = Auth::user();

        // Check if the current user is a manager
        if(Gate::allows('manager',$currentUser)){
            $user = $userToUpdate;
        }
        // Check if the current user is an admin and the user to update is a student
        elseif(Gate::allows('admin',$currentUser) && $userToUpdate->role ==='student'){
            $user = $userToUpdate;
        }
        // If the user is not authorized, redirect with an error message
        else{
            return redirect('/users')->with('error', 'Access denied. Only admins can perform this action.');
        }


        // Validate the request
        $request->validate([
            'password' => ['required','string','min:8','confirmed'],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();


        return redirect('/users')->with('success', 'Password updated successfully!');
    }

    public function destroy($id){
        // Get the current authenticated user
        $currentUser = Auth::user();

        // Find the user by ID
        $userToDelete = User::find($id); 

        // Check if the current user is a manager
        if(Gate::allows('manager', $currentUser)){
            $user = $userToDelete; 
        }
        // Check if the current user is an admin and the user to delete is a student
        elseif(Gate::allows('admin',$currentUser) && $userToDelete->role ==='student'){
            $user = $userToDelete;
        }
        // If the user is not authorized, redirect with an error message
        else{
            return redirect('/users')->with('error', 'Access denied. Only admins can perform this action.');
        }

        $user->delete();
        return redirect('/users')->with('success', 'User deleted successfully!');
    }

    public function create(){

        return view('users.admin.create');
    }

    public function store(Request $request){
        // Get current user 
        $currentUser = Auth::user();

        // validate 
        $request->validate([
            'username' => ['required','string','max:255',
            Rule::unique('users'),
        ],
            'email' => ['required','email',
            Rule::unique('users'),
        ],
            'password' => ['required','string','min:8','confirmed'],
            'role' => ['nullable','string','in:student,admin']
        ]);

        // Create new user
        $newUser = new User;
        $newUser->username = $request->username;
        $newUser->email = $request->email;
        $newUser->password = Hash::make($request->password);

        // If current user is a manager, assign role to new user
        if(Gate::allows('manager',$currentUser)){
            $newUser->role = $request->role;
        }else{
            $newUser->role = 'student';
        }

        $newUser->save();

        return redirect('/users')->with('success', 'User created successfully!');

    }

    public function editMe(){
        $user=Auth::user();
  
        return view('users.editMe', compact('user'));
    }

    public function updateMeDetalis(Request $request){
        // Get current user 
        $currentUser = User::find(Auth::user()->id);

        // validate 
        $request->validate([
            'username' => ['required','string','max:255',
            
        ],
            'email' => ['required','email',
            Rule::unique('users')->ignore($currentUser->id),
        ],
        ]);

        $currentUser->username = $request->username;
        $currentUser->email = $request->email;

        $currentUser->save();

        return redirect('dashboard')->with('success', 'Your details updated successfully!');

    }

    public function updateMePassword(Request $request){
        // Get current user 
        $currentUser = User::find(Auth::user()->id);

        // validate 
        $request->validate([
            'password_current' => ['required', 'string'],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        
        if(!Hash::check($request->password_current,$currentUser->password)){
            return redirect()->back()->withErrors(['password_current' => 'Current password is incorrect.']);
        }

        $currentUser->password = Hash::make($request->password);
        $currentUser->save();

        return redirect('dashboard')->with('success', 'Your password updated successfully!');
    }

    public function profile(){
        $userToShow = Auth::user();
        return view('users.me', compact('userToShow'));
    }


}
