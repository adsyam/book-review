<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function reviews()
    {
        return $this->hasMany(Review::class);
        // hasMany() method defines a one to many relationship between book and the reviews
        // it basically says that the book can have many reviews
    }
}
