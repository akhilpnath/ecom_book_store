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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable(); 
            $table->string('authors', 255)->nullable(); 
            $table->string('category', 500)->nullable();
            $table->string('language', 50)->nullable(); 
            $table->text('details')->nullable(); 
            $table->integer('price')->nullable(); 
            $table->string('image', 1000)->nullable(); 
            $table->timestamps();
            $table->index('category'); // Searching products by category
            $table->index('language'); // If filtering products by language
            $table->index('price'); // Sorting products by price
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
