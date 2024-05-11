<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;

class Book extends Model
{
    use HasFactory;

    public function Author()
    {
        return $this->belongsToMany(Author::class)->withPivot(['available'])->using(AuthorBook::class);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function listBooks()
    {
        $cacheKey = 'books_index';

        $cacheTime = now()->addMinutes(60);

        $books = Cache::remember($cacheKey, $cacheTime, function () {
            return Book::with('authors')->get();
        });

        return response()->json($books);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
