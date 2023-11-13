<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    // Defines a one-to-many relationship between a book and its reviews.
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Filters books based on their title.
    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    // Retrieves popular books with the most reviews within a specified date range.
    public function scopePopular(Builder $query, ?DateTime $from = null, ?DateTime $to = null): Builder
    {
        return $query->withCount([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to),
        ])
            ->orderBy('reviews_count', 'desc');
    }

    // Retrieves highest rated books based on the average rating of their reviews.
    public function scopeHighestRated(Builder $query, ?DateTime $from = null, ?DateTime $to = null): Builder
    {
        return $query->withAvg([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating')->orderByDesc('reviews_avg_rating');
    }

    public function scopeMinReviews(Builder $query, int $minReviews): Builder
    {
        return $query->having('reviews_count', '>=', $minReviews);
        // use having when working w/ aggregate functions like min, max, avg
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }

    public function scopePopularLastMonth(Builder $query): Builder
    {
        return $query
            ->popular(now()->subMonth()->now())
            ->highestRated(now()->subMonth()->now())
            ->minReviews(2);
    }

    public function scopePopularLast6Months(Builder $query): Builder
    {
        return $query->popular(now()->subMonth(6)->now())
            ->highestRated(now()->subMonth(6)->now())
            ->minReviews(5);
    }

    public function scopeHighestRatedLastMonth(Builder $query): Builder
    {
        return $query
            ->highestRated(now()->subMonth()->now())
            ->popular(now()->subMonth()->now())
            ->minReviews(2);
    }

    public function scopeHighestRatedLast6Month(Builder $query): Builder
    {
        return $query->highestRated(now()->subMonth(6)->now())
            ->popular(now()->subMonth(6)->now())
            ->minReviews(5);
    }
}
