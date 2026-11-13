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
        // Create the 'categories' table
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary key column
            $table->string('name'); // Name of the category
            $table->string('slug')->unique(); // Unique slug for the category
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
