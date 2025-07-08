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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->float('rate')->nullable();
            $table->foreignId('category_id')
            ->nullable()
            ->constrained('categories')
            ->nullOnDelete();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            //defualt address
            // $table->foreignId('address_id')
            // ->nullable()
            // ->constrained('worker_addresses')
            // ->nullOnDelete();
            $table->enum('status',['active','inactive','banned'])->default('inactive');
            $table->boolean('verify')->default(false);
            $table->boolean('candidate')->default(false);
            $table->timestamp('last_active_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
