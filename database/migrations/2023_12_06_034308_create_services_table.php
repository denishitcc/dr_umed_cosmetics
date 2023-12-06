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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name', 100);
            $table->string('parent_category', 100);
            $table->string('gender_specific', 100);
            $table->string('code', 100)->nullable();;
            $table->boolean('appear_on_calendar')->default(true);
            $table->string('duration', 50)->nullable();;
            $table->string('processing_time', 50)->nullable();;
            $table->string('fast_duration', 50)->nullable();;
            $table->string('slow_duration', 50)->nullable();;
            $table->string('usual_next_service', 50)->nullable();;
            $table->boolean('dont_include_reports')->default(true);
            $table->boolean('technical_service')->default(true);
            $table->boolean('available_on_online_booking')->default(true);
            $table->boolean('require_a_room')->default(true);
            $table->boolean('unpaid_time')->default(true);
            $table->string('follow_on_services', 100);
            $table->string('standard_price', 50)->nullable();
            $table->string('apprentice', 50)->nullable();
            $table->string('junior', 50)->nullable();
            $table->string('intermidiate', 50)->nullable();
            $table->string('senior', 50)->nullable();
            $table->string('very_senior', 50)->nullable();
            $table->string('gst_code', 50)->nullable();
            $table->string('concession', 100)->nullable();
            $table->boolean('chatwood')->default(true);
            $table->string('branch_standard_price', 50)->nullable();
            $table->string('branch_apprentice', 50)->nullable();
            $table->string('branch_junior', 50)->nullable();
            $table->string('branch_intermidiate', 50)->nullable();
            $table->string('branch_senior', 50)->nullable();
            $table->string('branch_very_senior', 50)->nullable();
            $table->boolean('ipswitch')->default(true);
            $table->boolean('hope_island')->default(true);
            $table->boolean('paddingtone')->default(true);
            $table->boolean('regents_park')->default(true);
            $table->boolean('sunshine_coast')->default(true);
            $table->boolean('greenacre')->default(true);
            $table->boolean('surfers_paradise')->default(true);
            $table->string('staff_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
