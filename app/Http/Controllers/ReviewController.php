<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with('reviewable')->get();
        return response()->json($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $review = Review::findOrFail($id);
        $this->authorize('update', $review);

        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $review->update($validated);
        return response()->json($review);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $this->authorize('delete', $review);

        $review->delete();
        return response()->json(['message' => 'Review deleted successfully']);
    }

    public function storeForBook(Request $request, $book_id)
    {
        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $book = Book::findOrFail($book_id);
        $review = $book->reviews()->create([
            'body' => $validated['body'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json($review, 201);
    }

    public function storeForAuthor(Request $request, $author_id)
    {
        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $author = Author::findOrFail($author_id);
        $review = $author->reviews()->create([
            'body' => $validated['body'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json($review, 201);
    }
}
