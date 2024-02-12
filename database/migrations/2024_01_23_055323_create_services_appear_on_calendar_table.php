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
        Schema::create('services_appear_on_calendars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('duration', 50)->nullable();
            $table->string('processing_time', 50)->nullable();
            $table->string('fast_duration', 50)->nullable();
            $table->string('slow_duration', 50)->nullable();
            $table->string('usual_next_service', 50)->nullable();
            $table->boolean('dont_include_reports')->default(false);
            $table->boolean('technical_service')->default(false);
            $table->boolean('available_on_online_booking')->default(true);
            $table->boolean('require_a_room')->default(false);
            $table->boolean('unpaid_time')->default(false);
            $table->boolean('require_a_follow_on_service')->default(false);
            $table->string('follow_on_services', 100)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_appear_on_calendars');
    }
};
