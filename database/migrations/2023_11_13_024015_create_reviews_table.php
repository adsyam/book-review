<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // $table->unsignedBigInteger('book_id'); // relates to foreign key below

            $table->text('review');
            $table->unsignedTinyInteger('rating');

            $table->timestamps();

            // $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            // foreign key
            // cascade ~ when a book record is deleted, all related reviews are also deleted

            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            // This is an easier setup with less flexibility
            // constrained method will automatically set up the foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
