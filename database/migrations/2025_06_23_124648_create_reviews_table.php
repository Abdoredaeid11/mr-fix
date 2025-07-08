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

    $table->foreignId('from_user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('to_user_id')->constrained('users')->onDelete('cascade');

    $table->foreignId('request_id')->constrained()->onDelete('cascade');

    $table->double('rating')->comment('1 to 5');
    $table->text('comment')->nullable();

    $table->timestamps();

    $table->unique(['from_user_id', 'to_user_id', 'request_id']); 
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
