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
        Schema::create('worker_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')
            ->constrained('users','id')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->longText('address')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('defualt')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_addresses');
    }
};
