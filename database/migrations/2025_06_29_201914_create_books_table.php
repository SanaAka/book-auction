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
        // This method defines all the columns for the 'books' table.
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // <-- This was missing
            $table->text('description');
            $table->string('author');
            $table->string('cover_image');
            $table->decimal('start_price', 8, 2);
            $table->enum('status', ['available', 'auctioned', 'sold'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};