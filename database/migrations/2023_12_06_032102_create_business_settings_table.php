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
        Schema::create('business_settings', function (Blueprint $table) {
            $table->id();
            $table->string('business_details_for', 100);
            $table->string('business_name', 100);
            $table->string('name_customers_see', 100);
            $table->string('business_email', 100);
            $table->string('business_phone', 20);
            $table->boolean('include_more_info')->default(true);
            $table->boolean('general_neutral_mode')->default(true);
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')
                  ->references('id')
                  ->on('locations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_settings');
    }
};
