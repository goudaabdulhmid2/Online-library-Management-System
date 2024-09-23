<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use  App\Http\Middleware\AdminMiddleware;
use Illuminate\Validation\Rule;

class GenreController extends Controller implements HasMiddleware
{
    
    public static function middleware(): array{
        return [
            'auth',
            new Middleware(AdminMiddleware::class)
        ];
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       

        return view('genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:genres',
        ]);

        Genre::create($data);

        return redirect()->route('dashboard')->with('success', 'Genre added successfully.');


    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        //
    }
}
