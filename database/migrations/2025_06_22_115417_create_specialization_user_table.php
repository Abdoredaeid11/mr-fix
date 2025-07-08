<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('specialization_user', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ✅ هنا التعديل
    $table->foreignId('specialization_id')->constrained()->onDelete('cascade');

    $table->decimal('price', 8, 2)->nullable();
    $table->timestamps();

    $table->unique(['user_id', 'specialization_id']); // ✅ كمان هنا
});
    }

    public function down(): void
    {
        Schema::dropIfExists('specialization_user');
    }
};
