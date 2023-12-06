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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('business_name', 100);
            $table->string('contact_first_name', 100)->nullable();
            $table->string('contact_last_name', 100)->nullable();
            $table->string('home_phone', 20)->nullable();
            $table->string('work_phone', 20)->nullable();
            $table->string('fax_number', 40)->nullable();
            $table->string('mobile_phone', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('web_address')->nullable();
            $table->text('street_address')->nullable();
            $table->string('suburb', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('post_code', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
