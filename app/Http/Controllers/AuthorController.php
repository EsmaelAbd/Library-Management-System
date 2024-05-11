<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Author::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $validatedData)
    {
        $author = Author::create($validatedData);
        return response()->json($author, 201);
        $author->books()->attach($request->book_id, ['available' => true]);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author, $id)
    {
        return response()->json(Author::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author, $id)
    {
        $author = Author::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|max:255',
        ]);

        $author->update($validatedData);
        return response()->json($author);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author, $id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
        return response()->json(['message' => 'Author deleted successfully']);
    }
}
