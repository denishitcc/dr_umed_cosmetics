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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('gender',10)->nullable();
            $table->string('email')->unique();
            $table->string('phone',20)->nullable();
            $table->string('role_type',50)->nullable();
            $table->string('image')->nullable();
            $table->string('banner_image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('status')->default('active'); // New field 'status'
            $table->rememberToken();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
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
