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
        Schema::create('message', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('number', 12);
            $table->string('message', 500);
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->index('user_id'); // Foreign key indexing
            $table->index('email'); // Commonly searched field
            $table->index('is_read'); // If filtering messages by read status
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message');
    }
};
