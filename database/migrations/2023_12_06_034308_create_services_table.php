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
            $table->string('service_name', 100)->nullable();
            $table->string('parent_category', 100)->nullable();
            $table->string('gender_specific', 100)->nullable();
            $table->string('code', 100)->nullable()->nullable();
            $table->boolean('appear_on_calendar')->default(true);
            $table->string('standard_price', 50)->nullable();
            $table->softDeletes();
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
