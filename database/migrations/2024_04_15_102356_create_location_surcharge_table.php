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
        Schema::create('location_surcharge', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id')->nullable(); // Define client_id column
            $table->string('surcharge_type', 100)->nullable();
            $table->text('surcharge_percentage')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            // Define foreign key constraints after columns are defined
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_surcharge');
    }
};
