<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(33)->create()->each(function ($book) {
            // generates random reviews
            $numReviews = random_int(5, 30);

            // for() ~ associate the created review with the book
            Review::factory()->count(5)->average()->for($book)->create();
        });

        Book::factory(33)->create()->each(function ($book) {
            // generates random reviews
            $numReviews = random_int(5, 30);

            // for() ~ associate the created review with the book
            Review::factory()->count(5)->good()->for($book)->create();
        });

        Book::factory(34)->create()->each(function ($book) {
            // generates random reviews
            $numReviews = random_int(5, 30);

            // for() ~ associate the created review with the book
            Review::factory()->count(5)->bad()->for($book)->create();
        });
    }
}
