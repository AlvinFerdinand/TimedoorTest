<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author_id', 'category_id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
