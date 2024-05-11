<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
