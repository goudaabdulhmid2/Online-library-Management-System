<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all books from the database and pass them to the view.
        $books = Book::with('genre')->paginate(10);

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Access denied. Only admins can perform this action.');
        }

        // Fetch all genres from the database and pass them to the view.
        $genres = Genre::all();

        return view('books.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Access denied. Only admins can perform this action.');
        }
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
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
