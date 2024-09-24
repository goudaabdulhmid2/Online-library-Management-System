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
        $genres = Genre::paginate(10);

        return view('genres.index', compact('genres'));
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
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $genre = Genre::find($id);
        return view('genres.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);
        $data = $request->validate([
            'name' => [
               'required',
               'string',
               'max:255',
               Rule::unique('genres')->ignore($id),
               ]]);

        $genre->update($data);

        return redirect('/genres')->with('success', 'Genre updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $genre = Genre::find($id);
        $genre->delete();

        return redirect('/genres')->with('success', 'Genre deleted successfully.');
    }
}
