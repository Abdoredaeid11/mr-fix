<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->enum('role', ['user', 'worker'])->default('user'); // 👈 النوع
            $table->foreignId('specialization_id')->nullable()->constrained('specializations')->nullOnDelete();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');
            $table->string('avatar')->nullable();

            // Worker/User common
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            // Worker-specific fields
            $table->float('rate')->nullable();
            $table->boolean('verify')->default(false);
            $table->boolean('candidate')->default(false);

            // User-specific fields
            $table->longText('address')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();

            $table->enum('status', ['active', 'inactive', 'banned'])->default('inactive');
            $table->timestamp('last_active_at')->nullable();
            $table->rememberToken();
            $table->string('device_token')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
