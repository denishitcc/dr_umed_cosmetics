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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('location_name',100)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('email');
            $table->string('street_address',100)->nullable();
            $table->string('suburb',100)->nullable();
            $table->string('city',50)->nullable();
            $table->string('state',50)->nullable();
            $table->string('postcode',10)->nullable();
            $table->decimal('latitude', 10, 8)->nullable(); // Example precision and scale, adjust as needed
            $table->decimal('longitude', 11, 8)->nullable(); // Example precision and scale, adjust as needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
