<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;




use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use  App\Http\Middleware\AdminMiddleware;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller implements HasMiddleware
{

    public static function middleware(): array{
        return [
            'auth',
            new Middleware(AdminMiddleware::class,except:['userBorrowed','userBorrowedUpdate','userBorrowCreate','userBorrowStore','usersBorrowed'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        if($search){
             
            $loans = Loan::where('loan_id', $search)->orderBy('loan_status','asc')->paginate(1);
        }else{
            $loans = Loan::orderBy('loan_status','asc')->paginate(10);
        }

                 
        foreach ($loans as $loan) {
            $remainingDays = Carbon::now()->diffInDays(Carbon::parse($loan->due_date));
             $loan->remainingDays = ceil($remainingDays);
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

        $remainingDays = Carbon::now()->diffInDays(Carbon::parse($loan->due_date));
        $loan->remainingDays = ceil($remainingDays);
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
    public function update(Request $request, $id)
    {
        // Find the loan
        $loan = Loan::findOrFail($id);
    
        // Validate the incoming request
        $data = $request->validate([
            'loan_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:loan_date'],
            'loan_status' => ['required', 'in:active,returned'],
        ]);
    
        // Check if the current loan status is 'returned'
        $checkCurrentStatus = $loan->loan_status == 'returned' ? 1 : 0;
    
        // Update the loan data
        if (!$checkCurrentStatus && $data['loan_status'] == 'returned') {
            // If changing to returned, set the return date and increment the book quantity
            $data['return_date'] = now(); 
            Book::where('book_id', $loan->book_id)->increment('quantity', 1);
        } elseif ($checkCurrentStatus && $data['loan_status'] == 'active') {
            // If changing back to active, remove the return date and decrement book quantity
            $data['return_date'] = null; 
            Book::where('book_id', $loan->book_id)->decrement('quantity', 1);
        }
    
        // Update the loan in the database
        $loan->update($data);
    
        // Redirect with success message
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

    /**
     * Display the user's active loan.
     */
    public function userBorrowed($id){

        $borrow = Loan::with('user','book')->find($id);
        if(!$borrow || Auth::user()->id !== $borrow->user_id){
            return redirect('dashboard')->with('error', 'No active loan found.');
        }

        $remainingDays = Carbon::now()->diffInDays(Carbon::parse($borrow->due_date));
        $borrow->remainingDays = ceil($remainingDays);
        

        return view('loans.user.show',compact('borrow'));
    }


    public function userBorrowedUpdate($id ){
                
        $borrow = Loan::with('user','book')->find($id);
        
        if(!$borrow || Auth::user()->id !== $borrow->user_id || $borrow->loan_status == 'returned'){
            return redirect('dashboard')->with('error', 'No active loan found.');
        }

      
        $borrow->return_date = now(); 
        $borrow->loan_status = 'returned';
        $borrow->save();

        Book::where('book_id', $borrow->book_id)->increment('quantity', 1);
       

        return redirect("/loans/user/$id")->with('success', 'Loan returned successfully.');

    }

    public function userBorrowCreate($id){

        // Check if the user is a student
        
        if(Auth::user()->role !== 'student'){
            return redirect('/books')->with('error', 'Only students can borrow books.');
        }

        $loan = Loan::where('book_id', $id)->where('loan_status', 'active')->where('user_id', Auth::user()->id)->exists();

        if($loan){
            return redirect('/books')->with('error', 'You have already borrowed this book.');
        }

        // Retrieve the book with its genre and check if it exists and is available
        $book =Book::with('genre')->find($id);

        if(!$book  || $book->quantity < 1){
            return redirect('/books')->with('error', 'No available books.');
        }

        return view('loans.user.create',compact('book'));
    }

    public function userBorrowStore(Request $request, $id)
    {
        // Check if the user is a student
        if(Auth::user()->role !== 'student'){
            return redirect('/books')->with('error', 'Only students can borrow books.');
        }
    
        // Find the book by its ID, 
        $book = Book::find($id);
    
        // Check if the book exists and if it's available for borrowing
        if(!$book || $book->quantity < 1){
            return redirect('/books')->with('error', 'No available books.');
        }
    
        // Check if the user has an active loan for the book
        $activeLoan = Loan::where('book_id', $id)
                          ->where('loan_status', 'active')
                          ->where('user_id', Auth::user()->id)
                          ->exists();
    
        if($activeLoan){
            return redirect('/books')->with('error', 'You have already borrowed this book.');
        }
    
        // Check if the user has a returned loan for this book
        $returnedLoan = Loan::where('book_id', $id)
                            ->where('loan_status', 'returned')
                            ->where('user_id', Auth::user()->id)
                            ->first();
    
        if($returnedLoan) {
            $returnedLoan->update([
                'loan_status' => 'active',
                'loan_date' => $request->loan_date,
                'due_date' => $request->due_date,
                'return_date' => null,
            ]);
    
            
            $book->decrement('quantity', 1);
    
            return redirect('/dashboard')->with('success', 'Book borrowed successfully.');
        }
    
        // Validate the loan and due dates for new loans
        $request->validate([
            'loan_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:loan_date'],
        ]);
    
        // Create a new loan for the user if no returned loan exists
        Loan::create([
            'user_id' => Auth::user()->id,
            'book_id' => $book->book_id,
            'loan_date' => $request->loan_date,
            'due_date' => $request->due_date,
            'loan_status' => 'active',
        ]);
    

        $book->decrement('quantity', 1);
    
        return redirect('/dashboard')->with('success', 'Book borrowed successfully.');
    }

    public function usersBorrowed(){

            // Check if the user is a student
            if(Auth::user()->role !== 'student'){
                return redirect('/books')->with('error', 'Only students.');
            }

            // Fetch all loans where the book quantity is less than 1
            $usersBorrows = Loan::with(['user', 'book']) ->whereHas('book', function ($query) {
                        $query->where('quantity', '<', 1);})->select('loans.*')->whereIn('loan_id', function ($query) {
                        $query->select(DB::raw('MIN(loan_id)')) 
                            ->from('loans')
                            ->join('books', 'loans.book_id', '=', 'books.book_id')
                            ->where('books.quantity', '<', 1)
                            ->groupBy('loans.book_id') 
                            ->orderBy('loans.due_date', 'asc'); })->get();

                return view('loans.user.index', compact('usersBorrows'));
    }


    
    
}
