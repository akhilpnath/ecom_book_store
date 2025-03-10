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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('name', 100);
            $table->integer('price');
            $table->integer('quantity');
            $table->string('image', 1000);
            $table->timestamps();
            $table->index('user_id'); // Foreign key indexing
            $table->index('product_id'); // Foreign key indexing
            $table->index(['user_id', 'product_id']); // Composite index to speed up cart queries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
