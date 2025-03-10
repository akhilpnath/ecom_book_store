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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('number', 12);
            $table->string('email', 100);
            $table->string('method', 50);
            $table->string('address', 500);
            $table->string('total_products', 1000);
            $table->integer('total_price');
            $table->string('placed_on', 50);
            $table->string('payment_status', 20)->default('pending');
            $table->timestamps();
            $table->index('user_id'); // Foreign key indexing
            $table->index('email'); // Searching by email
            $table->index(['user_id', 'payment_status']); // Composite index for faster queries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
