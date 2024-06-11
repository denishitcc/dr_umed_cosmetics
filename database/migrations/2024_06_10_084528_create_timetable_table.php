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
        Schema::create('timetable', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->string('name',255);
            $table->date('start_date');
            $table->text('days_of_week');
            $table->time('lunch');
            $table->time('break');
            $table->time('custom_time');
            $table->text('color_code');
            $table->integer('status')->comment('1-working,0-non working,2-leave,3-partial leave');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetable');
    }
};
