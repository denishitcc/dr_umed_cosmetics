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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('business_details_for', 100)->nullable();
            $table->string('business_name', 100)->nullable();
            $table->string('name_customers_see', 100)->nullable();
            $table->string('business_email', 100)->nullable();
            $table->string('business_phone', 20)->nullable();
            $table->string('website', 50)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('post_code', 20)->nullable();
            $table->string('timezone', 20)->nullable();
            $table->string('calendar_interval', 100)->nullable();
            $table->string('online_booking_website', 100)->nullable();
            $table->boolean('include_more_info')->default(true)->nullable();
            $table->boolean('general_neutral_mode')->default(true)->nullable();
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
