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
        Schema::create('working_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->integer('working_status')->comment('1-working,0-notworking,2-leave,3-partial_leave');
            $table->time('working_start_time')->nullable();
            $table->time('working_end_time')->nullable();
            $table->time('lunch_start_time')->nullable();
            $table->integer('lunch_duration')->nullable();
            $table->time('break_start_time')->nullable();
            $table->integer('break_duration')->nullable();
            $table->time('custom_start_time')->nullable();
            $table->time('custom_end_time')->nullable();
            $table->text('custom_reason')->nullable();
            $table->integer('leave_reason')->nullable()->comment('1-none,2-annual,3-public,4-sick,5-unpaid');
            $table->date('leave_start_date')->nullable();
            $table->date('leave_end_date')->nullable();
            $table->date('calendar_date')->nullable();
            $table->integer('paid_time')->nullable()->comment('1-yes,0-no');
            $table->timestamps();

            $table->foreign('staff_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_hours');
    }
};
