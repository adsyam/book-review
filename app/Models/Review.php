<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['review', 'rating'];

    public function book()
    {
        return $this->belongsTo(Book::class);
        // belongsTo() method is used to define an inverse side of the one to many relationship between a review and its book
        // also specifies that each review belong to one book
    }

    protected static function booted()
    {
        static::updated(fn(Review $review) => cache()->forget('book:' . $review->book_id));
        static::deleted(fn(Review $review) => cache()->forget('book:' . $review->book_id));
        static::created(fn(Review $review) => cache()->forget('book:' . $review->book_id));
    }




}
