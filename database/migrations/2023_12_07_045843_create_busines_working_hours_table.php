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
        Schema::create('busines_working_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')
                  ->references('id')
                  ->on('business_settings')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('day', 50)->nullable();
            $table->string('start_time', 100)->nullable();
            $table->string('end_time', 100)->nullable();
            $table->string('day_status', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('busines_working_hours');
    }
};
