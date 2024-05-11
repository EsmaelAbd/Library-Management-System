<?php

namespace App\Models;

use AppTraits\LogsModelStateChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;

class Author extends Model
{
    use HasFactory;
    use LogsModelStateChanges;

    protected $fillable = [
        'name',
        'email',
        'created_at',
    ];

    protected $hidden = [
        'password',
    ];

    public function Book()
    {
        return $this->belongsToMany(Book::class)->withPivot(['available'])->using(AuthorBook::class);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function listAuthors()
    {
        $cacheKey = 'authors_index';
        $cacheTime = now()->addMinutes(60);

        $authors = Cache::remember($cacheKey, $cacheTime, function () {
            return Author::all();
        });

        return response()->json($authors);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
