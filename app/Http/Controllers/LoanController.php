<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\Genre;
use App\Models\User;



use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use  App\Http\Middleware\AdminMiddleware;
use Illuminate\Validation\Rule;

class LoanController extends Controller implements HasMiddleware
{

    public static function middleware(): array{
        return [
            'auth',
            new Middleware(AdminMiddleware::class)
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        if($search){
             
            $loans = Loan::where('loan_id', $search)->paginate(1);
        }else{
            $loans = Loan::paginate(10);
        }

        return view('loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::where('quantity','>',0)->get();
        $users = User::where('role','=','student')->get();
        return view('loans.create', compact('books','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $data = $request->validate([
            'book_id' => [ 'required', 
                            Rule::exists('books', 'book_id')->where(function ($query) { $query->where('quantity', '>', 0);})
                         ],
            'user_id' => ['required', Rule::exists('users', 'id')->where('role','student')],
            'loan_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:loan_date'],
        ]);
         

        Loan::create($data);
        Book::where('book_id', $request->book_id)->decrement('quantity', 1);

        return redirect('/loans')->with('success', 'Loan created successfully.');
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $loan = Loan::with(['user','book'])->find($id);
        return view('loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $loan = Loan::with(['user','book'])->find($id);
        $books = Book::where('quantity','>',0)->get();
        $users = User::where('role','=','student')->get();
        return view('loans.edit', compact('loan','books','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
       $loan = Loan::find($id);
       $data = $request->validate([
            'loan_date'=>['required', 'date'],
            'due_date'=>['required', 'date', 'after_or_equal:loan_date'], 
            'loan_status'=>['required', 'in:active,returned']  
        ]);
        $checkCurrentStatus = $loan->loan_status == 'returned'? 1:0;
        $loan->update($data);

        if(!$checkCurrentStatus && $data['loan_status'] == 'returned' ){
            Book::where('book_id', $loan->book_id)->increment('quantity', 1);
        }elseif($checkCurrentStatus && $data['loan_status'] == 'active'){
            Book::where('book_id', $loan->book_id)->decrement('quantity', 1);
        }

        return redirect('/loans')->with('success', 'Loan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $loan =  Loan::find($id);
       $checkCurrentStatus = $loan->loan_status =='active' ? 1 : 0;
       $loan->delete();
       
       if($checkCurrentStatus){
            Book::where('book_id', $loan->book_id)->increment('quantity', 1);
        }
       return redirect('/loans')->with('success', 'Loan deleted successfully.');
    }
}
