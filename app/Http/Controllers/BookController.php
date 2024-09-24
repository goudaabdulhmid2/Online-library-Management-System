<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Loan;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use  App\Http\Middleware\AdminMiddleware;
use Illuminate\Validation\Rule;



use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;


class BookController extends Controller implements HasMiddleware 
{

    public static function middleware(){
        return [
            new Middleware('auth',except:['index','show']),
            new Middleware(AdminMiddleware::class,except:['index','show'])
        ];
    }
    public function index(Request $request)
    {
        // Retrieve the search query from the request
        $search = $request->input('search');

        // If a search query is provided, filter the books based on the title using a LIKE query.
        if($search){
             // Query to get books, allowing partial matches with the 'LIKE' operator
            $books = Book::when($search, function($query, $search) {
                return $query->where('title', 'LIKE', '%' . $search . '%');
            })->paginate(10); 
        }
        // If no search query is provided, fetch all books from the database and paginate them
        else{
        
            $books = Book::paginate(10);
         }
    
        return view('books.index', compact('books'));
    }


    public function create()
    {
        // Fetch all genres from the database and pass them to the view.
        $genres = Genre::all();
        return view('books.create', compact('genres'));
    }


    public function store(Request $request)
    {
        // validate
        $data = $request->validate(
            [
                'title' => ['required','string','max:255','unique:books'],
                'author' => ['required','string','max:255'],
                'genre_id' => ['required','integer','exists:genres,id'],
                'description' => ['required','string'],
                "quantity" => ['required','integer']
            ]
        );


        // Create a new book in the database
        Book::create($data);

        // Redirect to the dashboard page
        return redirect()->route('dashboard')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = Book::find($id);
        $bookBorrowed = Loan::where('book_id', $book->book_id)->count();
        $book->quantity -=  $bookBorrowed;
        $book->borrowed = $bookBorrowed;

        // Fetch all users who have borrowed this book and pass them to the view.
        $loans = Loan::with('user')->where('book_id', $book->book_id)->where('loan_status','active')->paginate(10);

        //dd($loans);

        return view('books.show', compact('book', 'loans'));
    }

  
    public function edit($id)
    {
        // Fetch all genres from the database and pass them to the view.
        $genres = Genre::all();

        // Find the book with the given ID in the database
        $book = Book::find($id);

        // Pass the book and genres to the view
        return view('books.edit', compact('book', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        // Get book
        $book = Book::find($id);


        // Validate the data
        $data = $request->validate(
            [
                'title' => ['required','string','max:255',
                Rule::unique('books')->ignore($book->book_id,'book_id'),
            ],
                'author' => ['required','string','max:255'],
                'genre_id' => ['required','integer','exists:genres,id'],
                'description' => ['required','string'],
                "quantity" => ['required','integer']
            ]
        );


        // Update the book in the database
        $book->update($data);

        // Redirect to the dashboard page
        return redirect("/books/$book->book_id")->with('success', 'Book updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Delete the book from the database
        $book->delete();

        // Redirect to the dashboard page
        return redirect('/books')->with('success', 'Book deleted successfully.');
    }
}
